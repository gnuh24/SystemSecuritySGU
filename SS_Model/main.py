import random
from PIL import Image
import io
from flask import Flask, request, jsonify
import tensorflow as tf
import numpy as np
import cv2
import os
from tensorflow.keras import Sequential, Model
from keras.layers import Input, Dense, Conv2D, MaxPooling2D, Flatten
from tensorflow.keras import optimizers
import matplotlib.pyplot as plt
import pandas as pd

app = Flask(__name__)

# Đường dẫn chứa dữ liệu huấn luyện
data_path = 'Data'


def load_label_mapping(filepath):
    label_mapping = {}
    if os.path.exists(filepath):
        with open(filepath, 'r') as f:
            for line in f:
                label, idx = line.strip().split(': ')
                label_mapping[label] = int(idx)
    return label_mapping

def preprocess_image(image_path):
    img = cv2.imread(image_path, cv2.IMREAD_GRAYSCALE)
    img = cv2.resize(img, (128, 128))  # Resize ảnh về 128x128
    img = img / 255.0  # Chuẩn hóa pixel về [0, 1]
    img = np.expand_dims(img, axis=-1)  # Thêm chiều channel để có dạng (128, 128, 1)
    img = np.expand_dims(img, axis=0)  # Thêm chiều batch để có dạng (1, 128, 128, 1)
    return img


@app.route('/recognize', methods=['POST'])
def recognize():
    global loaded_model  # Sử dụng biến toàn cục loaded_model
    # Nhận file từ yêu cầu
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    file = request.files['file']

    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    # Lưu file tạm thời
    file_path = os.path.join('temp', file.filename)
    file.save(file_path)

    # Tiến hành nhận dạng
    processed_image = preprocess_image(file_path)

    predictions = loaded_model.predict(processed_image)
    predicted_idx = np.argmax(predictions, axis=1)[0]
    predicted_probabilities = predictions.tolist()

    # Ánh xạ giá trị dự đoán sang nhãn
    predicted_label = list(label_mapping.keys())[list(label_mapping.values()).index(predicted_idx)]

    return jsonify({
        'predicted_label': predicted_label,
        'predicted_probabilities': predicted_probabilities
    })


def save_label_mapping(new_label_dict, filename):
    with open(filename, 'a') as f:  # Mở file ở chế độ append
        for label, index in new_label_dict.items():
            f.write(f"{label}: {index}\n")

def expand_output_layer(model, new_output_units):
    """
    Mở rộng lớp đầu ra của mô hình để thêm nhãn mới, giữ nguyên các trọng số của các nhãn cũ.
    """
    try:
        # Lấy lớp đầu ra hiện tại
        old_output_layer = model.layers[-1]
        old_weights, old_biases = old_output_layer.get_weights()
        old_output_units = old_weights.shape[1]  # Số lượng nhãn cũ

        # Xác định đầu vào của mô hình hiện tại
        input_shape = model.input_shape[1:]  # Tránh batch size
        new_input = Input(shape=input_shape)  # Định nghĩa lớp Input với kích thước tương tự

        # Tạo mô hình mới với các lớp trước lớp đầu ra cuối cùng
        x = new_input
        for layer in model.layers[:-1]:
            x = layer(x)

        # Tạo lớp Dense mới với số nhãn mới
        new_output_layer = Dense(new_output_units, activation='softmax', name='output_layer_expanded')(x)

        # Tạo mô hình mới
        new_model = Model(inputs=new_input, outputs=new_output_layer)

        # Khởi tạo trọng số mới cho lớp đầu ra
        new_weights = np.zeros((old_weights.shape[0], new_output_units))
        new_biases = np.zeros(new_output_units)

        # Giữ lại trọng số của các nhãn cũ
        new_weights[:, :old_output_units] = old_weights
        new_biases[:old_output_units] = old_biases

        # Đặt trọng số mới cho lớp đầu ra mở rộng
        new_model.layers[-1].set_weights([new_weights, new_biases])

        return new_model
    except Exception as e:
        print(f"Lỗi khi mở rộng lớp đầu ra: {str(e)}")
        raise

@app.route('/train', methods=['POST'])
def train():
    # Kiểm tra xem có tệp nào được tải lên không
    if 'files[]' not in request.files:
        return jsonify({'error': 'No files uploaded'}), 400

    # Lấy danh sách tệp được tải lên
    files = request.files.getlist('files[]')

    # Tải dữ liệu từ các tệp đã tải lên
    new_data = load_data_from_files(files)
    if not new_data:
        return jsonify({'error': 'No valid images found'}), 400

    # Đường dẫn tới các thư mục lưu trữ
    dataPath = 'Data'
    test_path = 'test'

    # Đảm bảo các thư mục tồn tại
    os.makedirs(dataPath, exist_ok=True)
    os.makedirs(test_path, exist_ok=True)

    # Lưu các tệp vào thư mục Data
    saved_paths = []
    for file in files:
        file.seek(0)  # Đặt con trỏ về đầu tệp
        file_bytes = file.read()  # Đọc nội dung tệp

        # Kiểm tra tính hợp lệ của ảnh bằng OpenCV
        np_array = np.frombuffer(file_bytes, np.uint8)
        img_cv = cv2.imdecode(np_array, cv2.IMREAD_GRAYSCALE)

        if img_cv is None:
            print(f"Không thể nhận diện ảnh từ file: {file.filename}")
            continue  # Bỏ qua nếu không phải là ảnh hợp lệ

        # Lưu tệp vào thư mục Data
        file_path = os.path.join(dataPath, file.filename)
        with open(file_path, 'wb') as f:
            f.write(file_bytes)
        saved_paths.append(file_path)

    # Lưu một tệp vào thư mục test
    if files:
        files[0].seek(0)  # Đặt con trỏ về đầu tệp
        file_bytes = files[0].read()  # Đọc nội dung tệp

        # Lưu tệp vào thư mục test
        test_file_path = os.path.join(test_path, files[0].filename)
        with open(test_file_path, 'wb') as f:
            f.write(file_bytes)

    train_data = loading_data(dataPath)
    img, labels = [], []

    for label, image in train_data:
        img.append(image)
        labels.append(label)

    img_array = np.array(img)  # Tạo mảng từ danh sách img
    train_data = np.array(img).reshape(-1, 128, 128, 1) / 255.0
    labels = np.array(labels)  # Chuyển đổi nhãn thành mảng NumPy

    # Ánh xạ nhãn
    label_dict = {label: idx for idx, label in enumerate(set(labels))}
    train_labels = np.array([label_dict[label] for label in labels])

    # Tạo mô hình mới
    model = create_model(len(label_dict))

    # Huấn luyện mô hình
    early_stopping_cb = tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=10)
    history = model.fit(train_data, train_labels, batch_size=128, epochs=30,
                        validation_split=0.2, callbacks=[early_stopping_cb], verbose=1)

    # Đánh giá mô hình trên dữ liệu kiểm tra
    test_data, test_labels = prepare_test_data(test_path, label_dict)
    model.evaluate(test_data, test_labels)

    # Lưu mô hình và ánh xạ nhãn
    model.save('my_model.h5')  # Ghi đè tệp cũ
    save_label_mapping(label_dict, 'label_mapping.txt')

    return jsonify({'status': 'Training completed and model saved'})
# Tạo mô hình mới
def create_model(num_classes):
    model = Sequential([
        Conv2D(32, 3, padding='same', activation='relu', kernel_initializer='he_uniform', input_shape=[128, 128, 1]),
        MaxPooling2D(2),
        Conv2D(64, 3, padding='same', kernel_initializer='he_uniform', activation='relu'),
        MaxPooling2D(2),
        Flatten(),
        Dense(128, kernel_initializer='he_uniform', activation='relu'),
        Dense(num_classes, activation='softmax')
    ])
    model.compile(optimizer=optimizers.Adam(1e-3), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
    return model
# Lưu ánh xạ nhãn
def save_label_mapping(label_dict, output_file_path):
    with open(output_file_path, "w") as file:
        for label, idx in label_dict.items():
            file.write(f"{label}: {idx}\n")
    print(f"Đã lưu file {output_file_path} chứa ánh xạ nhãn.")

# Chuẩn bị dữ liệu kiểm tra
def prepare_test_data(test_path, label_dict):
    test_images = []
    test_labels = []

    # Lấy tất cả hình ảnh từ test_path
    for filename in os.listdir(test_path):
        if filename.endswith(('.png', '.jpg', '.jpeg')):
            img_path = os.path.join(test_path, filename)
            img = cv2.imread(img_path, cv2.IMREAD_GRAYSCALE)
            if img is not None:
                # Đảm bảo kích thước hình ảnh đúng
                img = cv2.resize(img, (128, 128))
                test_images.append(img)

                # Giả sử tên tệp chứa nhãn
                label = filename.split('_')[0]  # Lấy nhãn từ tên tệp
                if label in label_dict:
                    test_labels.append(label_dict[label])

    # Kiểm tra kích thước của test_images
    print(f"Số hình ảnh trong test_images: {len(test_images)}")

    # Chỉ reshape nếu có đủ hình ảnh
    if len(test_images) > 0:
        test_images = np.array(test_images).reshape(-1, 128, 128, 1) / 255.0
        test_labels = np.array(test_labels)
    else:
        raise ValueError("Không có hình ảnh hợp lệ nào trong test_images.")

    return test_images, test_labels


def load_data_from_files(files):
    data = []
    for file in files:
        try:
            img_array = cv2.imdecode(np.frombuffer(file.read(), np.uint8), cv2.IMREAD_GRAYSCALE)
            if img_array is None:
                print(f"Không thể đọc ảnh từ file: {file.filename}")
                continue

            img_resized = cv2.resize(img_array, (128, 128))
            img_resized = img_resized / 255.0  # Chuẩn hóa pixel về [0, 1]
            img_resized = np.expand_dims(img_resized, axis=-1)  # Thêm chiều channel

            label = extract_label(file.filename)
            data.append([label, img_resized])
        except Exception as e:
            print(f"Lỗi khi xử lý ảnh {file.filename}: {e}")
            continue
    return data


def load_model():
    if os.path.exists('my_model.h5'):
        model = tf.keras.models.load_model('my_model.h5')
        return model
    else:
        # Tạo mô hình mới
        model = Sequential()
        model.add(Conv2D(32, (3, 3), activation='relu', input_shape=(128, 128, 1)))
        model.add(MaxPooling2D(pool_size=(2, 2)))
        model.add(Conv2D(64, (3, 3), activation='relu'))
        model.add(MaxPooling2D(pool_size=(2, 2)))
        model.add(Flatten())
        model.add(Dense(len(label_mapping), activation='softmax'))
        model.compile(optimizer=optimizers.Adam(1e-4), loss='sparse_categorical_crossentropy', metrics=['accuracy'])
        return model




def extract_label(img_path):
    filename, _ = os.path.splitext(os.path.basename(img_path))
    label = filename.split('_')[0]
    return label


def loading_data(path):
    print("Loading data from: ", path)
    data = []

    for img in os.listdir(path):
        try:
            img_path = os.path.join(path, img)
            img_array = cv2.imread(img_path, cv2.IMREAD_GRAYSCALE)
            if img_array is None:
                print(f"Không thể đọc ảnh: {img_path}")
                continue  # Bỏ qua nếu không đọc được ảnh

            img_resize = cv2.resize(img_array, (128, 128))  # Đổi kích thước ảnh
            label = extract_label(img_path)  # Lấy nhãn từ tên tệp
            data.append([label, img_resize])  # Thêm nhãn và ảnh đã được định dạng vào danh sách

        except Exception as e:
            print(f"Lỗi khi xử lý ảnh {img}: {e}")  # In ra lỗi nếu có
    return data

if __name__ == '__main__':
    # Tải ánh xạ nhãn từ file
    label_mapping = load_label_mapping('label_mapping.txt')
    loaded_model = load_model()  # Tải mô hình nếu có
    app.run(debug=True)

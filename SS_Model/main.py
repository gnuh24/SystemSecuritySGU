
from flask import Flask, request, jsonify

from tensorflow.keras import Sequential, Model
from keras.layers import Input, Dense, Conv2D, MaxPooling2D, Flatten
from tensorflow.keras import optimizers

import os
import numpy as np
import cv2
import tensorflow as tf
from sklearn.metrics import classification_report, confusion_matrix
import matplotlib.pyplot as plt
from flask import request, jsonify

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
    label_mapping = load_label_mapping('label_mapping.txt')

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

    try:
        # Tiến hành nhận dạng
        processed_image = preprocess_image(file_path)

        predictions = loaded_model.predict(processed_image)
        predicted_idx = np.argmax(predictions, axis=1)[0]
        predicted_probabilities = predictions.tolist()
        predicted_label = list(label_mapping.keys())[list(label_mapping.values()).index(predicted_idx)]

        # Kiểm tra kiểu dữ liệu của predicted_probabilities
        if isinstance(predicted_probabilities, list):
            # Nếu là list, kiểm tra xem nó có phải là list đơn hay list chứa list con
            if all(isinstance(i, (list, np.ndarray)) for i in predicted_probabilities):
                # Nếu predicted_probabilities là một list chứa các list con (mảng 2D)
                filtered_probabilities = [prob for sublist in predicted_probabilities for prob in sublist if prob < 1]
            else:
                # Nếu predicted_probabilities là list một chiều
                filtered_probabilities = [prob for prob in predicted_probabilities if prob < 1]

            # Nếu có giá trị nhỏ hơn 1, lấy giá trị lớn nhất trong số đó
            if filtered_probabilities:
                max_value_less_than_1 = max(filtered_probabilities)
            else:
                max_value_less_than_1 = 0  # Nếu không có giá trị nào nhỏ hơn 1, gán mặc định là 0
        else:
            # Nếu predicted_probabilities là mảng NumPy hoặc kiểu khác
            predicted_probabilities = np.array(predicted_probabilities).flatten()  # Biến đổi thành mảng một chiều
            filtered_probabilities = [prob for prob in predicted_probabilities if prob < 1]

            if filtered_probabilities:
                max_value_less_than_1 = max(filtered_probabilities)
            else:
                max_value_less_than_1 = 0  # Nếu không có giá trị nào nhỏ hơn 1, gán mặc định là 0

        # Trả về kết quả JSON
        return jsonify({
            'predicted_label': predicted_label,
            'predicted_probabilities': predicted_probabilities,
            'Accuracy': 100 * max_value_less_than_1
        })

    finally:
        # Xóa tệp tạm thời sau khi xử lý xong
        if os.path.exists(file_path):
            os.remove(file_path)

def save_label_mapping(new_label_dict, filename):
    with open(filename, 'a') as f:  # Mở file ở chế độ append
        for label, index in new_label_dict.items():
            f.write(f"{label}: {index}\n")


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

    # Tải và xử lý dữ liệu
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
    loss, accuracy = model.evaluate(test_data, test_labels)
    print(f"Test Loss: {loss}")
    print(f"Test Accuracy: {accuracy}")

    # Dự đoán trên tập kiểm tra
    predictions = model.predict(test_data)
    predicted_labels = np.argmax(predictions, axis=1)

    # Lọc các nhãn hợp lệ cho classification_report và confusion_matrix
    valid_labels = np.unique(test_labels)
    valid_label_names = [key for key, value in label_dict.items() if value in valid_labels]

    # Hiển thị báo cáo phân loại
    print("Classification Report:")
    print(classification_report(
        test_labels,
        predicted_labels,
        target_names=valid_label_names,
        labels=valid_labels
    ))

    # Ma trận nhầm lẫn
    cm = confusion_matrix(test_labels, predicted_labels, labels=valid_labels)
    print("Confusion Matrix:")
    print(cm)

    # Vẽ ma trận nhầm lẫn
    plt.figure(figsize=(8, 8))
    plt.imshow(cm, cmap='Blues')
    plt.title("Confusion Matrix")
    plt.colorbar()
    plt.xlabel("Predicted Labels")
    plt.ylabel("True Labels")
    plt.xticks(ticks=np.arange(len(valid_labels)), labels=valid_label_names, rotation=45)
    plt.yticks(ticks=np.arange(len(valid_labels)), labels=valid_label_names)
    plt.savefig('confusion_matrix.png')  # Lưu hình ảnh ma trận nhầm lẫn vào file

    # Hiển thị một vài hình ảnh kiểm tra và dự đoán
    plt.figure(figsize=(10, 10))
    for i in range(min(9, len(test_data))):
        ax = plt.subplot(3, 3, i + 1)
        plt.imshow(test_data[i].reshape(128, 128), cmap='gray')
        true_label = valid_label_names[np.where(valid_labels == test_labels[i])[0][0]]
        predicted_label = valid_label_names[np.where(valid_labels == predicted_labels[i])[0][0]]
        plt.title(f"True: {true_label}\nPred: {predicted_label}")
        plt.axis("off")

    # Lưu mô hình và ánh xạ nhãn
    model.save('my_model.h5')  # Ghi đè tệp cũ
    save_label_mapping(label_dict, 'label_mapping.txt')

    return jsonify({'status': 'Training completed and model saved',
                    'Accuracy':accuracy})

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

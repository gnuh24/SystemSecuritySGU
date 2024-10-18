<?php
function connectdb()
{
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'sgu_systemsecurity';
    $conn = new mysqli($server, $user, $pass, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    return $conn;  // Trả về đối tượng kết nối
}

function checkUser($user, $pass)
{
    $conn = connectdb();  // Lấy đối tượng kết nối từ hàm connectdb()

    // Sử dụng prepared statements để tránh SQL injection
    $stmt = $conn->prepare("SELECT * FROM account WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);  // "ss" đại diện cho hai chuỗi

    // Thực thi câu lệnh
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['role'];  // Giả sử cột 'role' tồn tại trong bảng 'account'
    } else {
        return null;  // Không tìm thấy người dùng phù hợp
    }

    // Đóng kết nối và statement
    $stmt->close();
    $conn->close();
}

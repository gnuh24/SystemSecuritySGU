<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="ManagerHomePageUI.css">
    <!-- jQuery library (for Ajax) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="manager-dashboard">
        <h1>Manager Dashboard</h1>
        <div class="manager-content">
            <div class="manage-buttons">
                <button id="manage-profiles">Manage Profiles</button>
                <button id="manage-shifts">Manage Shifts</button>
                <button id="statistics">Statistic</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Sự kiện khi nhấn nút Manage Profiles
            $('#manage-profiles').click(function () {
                // Gửi yêu cầu ajax để lấy dữ liệu hồ sơ trước khi chuyển trang
                $.ajax({
                        url: 'http://localhost:8080/api/Profile/List',  // Đường dẫn API
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')  // Thêm token vào header
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response); // Xử lý phản hồi thành công
                            Swal.fire({
                                title: 'Profile Data Loaded',
                                text: 'Profile data has been loaded successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "../Profile/QLProfile.php";  // Chuyển hướng sau khi load thành công
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to load profile data. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    });

            });

            // Sự kiện khi nhấn nút Manage Shifts
            $('#manage-shifts').click(function () {
                $.ajax({
                        url: 'http://localhost:8080/api/Shift/List',  // Đường dẫn API
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')  // Thêm token vào header
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response); // Xử lý phản hồi thành công
                            Swal.fire({
                                title: 'Shift Data Loaded',
                                text: 'Shift data has been loaded successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "../Shift/QLShift.php";  // Chuyển hướng sau khi load thành công
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to load profile data. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    });
            });

            // Sự kiện khi nhấn nút Statistics
            $('#statistics').click(function () {
                // Có thể thêm xử lý cho nút này nếu cần
                Swal.fire({
                    title: 'Statistics',
                    text: 'Feature is under construction!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>

</body>

</html>

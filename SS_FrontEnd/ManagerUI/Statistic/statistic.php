<?php
// Hàm gọi API và trả về dữ liệu JSON
function getApiData($url, $token, $startDate, $endDate)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url?startDate=$startDate&endDate=$endDate");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Thêm token vào tiêu đề
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzMwMTQ2MjkwLCJleHAiOjE3MzI3MzgyOTB9.LnNNSXBVWZfgCYDAtNKTGQ30zS8M_-7KZbMRr83-mN0',
    ]);

    $output = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if (curl_errno($ch)) {
        die('CURL error: ' . curl_error($ch));
    }

    curl_close($ch);
    return json_decode($output, true); // Chuyển JSON thành array
}

// Hàm gọi API chi tiết ca làm việc
function getShiftDetail($profileCode, $token)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/api/Statistic/ShiftDetail?profileCode=$profileCode");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Thêm token vào tiêu đề
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzMwMTQ2MjkwLCJleHAiOjE3MzI3MzgyOTB9.LnNNSXBVWZfgCYDAtNKTGQ30zS8M_-7KZbMRr83-mN0',
    ]);

    $output = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if (curl_errno($ch)) {
        die('CURL error: ' . curl_error($ch));
    }

    curl_close($ch);
    $response = json_decode($output, true); // Chuyển JSON thành array

    // Kiểm tra mã trạng thái
    if ($response['status'] !== 200) {
        die('Có lỗi khi lấy chi tiết ca làm việc từ API: ' . $response['message']);
    }

    return $response; // Nếu không có lỗi, trả về dữ liệu
}

// Xử lý yêu cầu khi người dùng nhấn nút xem thống kê hoặc chi tiết
$data = [];
$shiftDetails = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['view_stats'])) {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        // URL của API
        $apiUrl = 'http://localhost:8080/api/Statistic/ProfileWorkSummary';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzI3MDk3MTUwLCJleHAiOjE3Mjk2ODkxNTB9.7rMknTboogqhKHDgy4urBUzlFpGu7BkSOYrEzt8PAjA'; // Thay thế bằng token thật của bạn

        $data = getApiData($apiUrl, $token, $startDate, $endDate); // Gọi API và nhận dữ liệu

        // Kiểm tra dữ liệu từ API
        if ($data['status'] !== 200) {
            die('Có lỗi khi lấy dữ liệu từ API.');
        }
    }
    if (isset($_POST['view_detail'])) {
        $profileCode = $_POST['profile_code'];
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzI3MDk3MTUwLCJleHAiOjE3Mjk2ODkxNTB9.7rMknTboogqhKHDgy4urBUzlFpGu7BkSOYrEzt8PAjA'; // Thay thế bằng token thật của bạn

        $shiftDetails = getShiftDetail($profileCode, $token); // Gọi API chi tiết ca làm việc

        // Kiểm tra dữ liệu từ API
        if ($shiftDetails['status'] !== 200) {
            die('Có lỗi khi lấy chi tiết ca làm việc từ API.');
        }
    }
}

// Chuẩn bị dữ liệu cho biểu đồ
$names = [];
$totalHoursWorked = [];
$totalHoursWorkedOT = [];
$totalMinutesLeavingEarly = [];
$totalMinutesLate = [];
$totalShiftSignUp = [];
$totalWorkingShift = [];
$totalDaysNotWorked = [];

if (!empty($data['data'])) {
    foreach ($data['data'] as $employee) {
        $names[] = $employee['profileName'];
        $totalHoursWorked[] = $employee['totalHoursWorkedOfficial'];
        $totalHoursWorkedOT[] = $employee['totalHoursWorkedOT'];
        $totalMinutesLeavingEarly[] = $employee['totalMinutesLeavingEarly'];
        $totalMinutesLate[] = abs($employee['totalMinutesLate']); // Lấy giá trị tuyệt đối
        $totalShiftSignUp[] = $employee['totalShiftSignUp'];
        $totalWorkingShift[] = $employee['totalWorkingShift'];
        $totalDaysNotWorked[] = $employee['totalDaysNotWorked'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê giờ làm việc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: aliceblue;
            margin: 0;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            margin: 0;
        }

        .form-container {
            margin-bottom: 40px;
            text-align: center;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #004494;
            transform: scale(1.05);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        canvas {
            max-width: 100%;
            height: 400px;
            margin-bottom: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            margin-top: 50px;
            color: #6c757d;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: black;
        }

        .table-bordered {
            border: 2px solid #dee2e6;
        }
        #container11{
            margin-top:20px;
        }
    </style>
</head>

<body>
    <?php include_once '../../Header.php'; ?>

    
    <div class="container" id="container11">
        <div class="form-container">
            <form method="POST" class="form-inline justify-content-center">
                <div class="form-group mx-2">
                    <label for="start_date" class="mr-2">Ngày bắt đầu:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group mx-2">
                    <label for="end_date" class="mr-2">Ngày kết thúc:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" name="view_stats" class="btn btn-primary"><i class="fas fa-search"></i> Xem thống kê</button>
            </form>
        </div>

        <?php if (!empty($names)): ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#workHours" data-toggle="tab">Giờ làm việc chính thức</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#workHoursOT" data-toggle="tab">Giờ làm thêm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#earlyLate" data-toggle="tab">Phút về sớm & Đi muộn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#shiftStatistics" data-toggle="tab">Số ca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#daysNotWorked" data-toggle="tab">Ngày không làm việc</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="workHours">
                    <div class="card p-4">
                        <canvas id="workHoursChart"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade" id="workHoursOT">
                    <div class="card p-4">
                        <canvas id="workHoursOTChart"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade" id="earlyLate">
                    <div class="card p-4">
                        <canvas id="earlyLateChart"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade" id="shiftStatistics">
                    <div class="card p-4">
                        <canvas id="shiftChart"></canvas>
                    </div>
                </div>
                <div class="tab-pane fade" id="daysNotWorked">
                    <div class="card p-4">
                        <canvas id="daysNotWorkedChart"></canvas>
                    </div>
                </div>
            </div>

            <script>
                // Lấy dữ liệu từ PHP
                const employeeNames = <?php echo json_encode($names); ?>;
                const totalHoursWorked = <?php echo json_encode($totalHoursWorked); ?>;
                const totalHoursWorkedOT = <?php echo json_encode($totalHoursWorkedOT); ?>;
                const totalMinutesLeavingEarly = <?php echo json_encode($totalMinutesLeavingEarly); ?>;
                const totalMinutesLate = <?php echo json_encode($totalMinutesLate); ?>;
                const totalShiftSignUp = <?php echo json_encode($totalShiftSignUp); ?>;
                const totalWorkingShift = <?php echo json_encode($totalWorkingShift); ?>;
                const totalDaysNotWorked = <?php echo json_encode($totalDaysNotWorked); ?>;

                // Vẽ biểu đồ giờ làm việc chính thức
                const ctxWorkHours = document.getElementById('workHoursChart').getContext('2d');
                new Chart(ctxWorkHours, {
                    type: 'bar',
                    data: {
                        labels: employeeNames,
                        datasets: [{
                            label: 'Giờ làm việc chính thức',
                            data: totalHoursWorked,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Giờ'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });

                // Vẽ biểu đồ giờ làm thêm
                const ctxWorkHoursOT = document.getElementById('workHoursOTChart').getContext('2d');
                new Chart(ctxWorkHoursOT, {
                    type: 'bar',
                    data: {
                        labels: employeeNames,
                        datasets: [{
                            label: 'Giờ làm thêm',
                            data: totalHoursWorkedOT,
                            backgroundColor: 'rgba(255, 206, 86, 0.6)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Giờ'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });

                // Vẽ biểu đồ phút về sớm và phút đi muộn
                const ctxEarlyLate = document.getElementById('earlyLateChart').getContext('2d');
                new Chart(ctxEarlyLate, {
                    type: 'bar',
                    data: {
                        labels: employeeNames,
                        datasets: [{
                                label: 'Phút về sớm',
                                data: totalMinutesLeavingEarly,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Tổng phút đi muộn',
                                data: totalMinutesLate,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Phút'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });

                // Vẽ biểu đồ số ca (Đăng ký + Làm việc)
                const ctxShift = document.getElementById('shiftChart').getContext('2d');
                new Chart(ctxShift, {
                    type: 'bar',
                    data: {
                        labels: employeeNames,
                        datasets: [{
                                label: 'Số ca đăng ký',
                                data: totalShiftSignUp,
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Số ca làm việc',
                                data: totalWorkingShift,
                                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Số ca'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });

                // Vẽ biểu đồ ngày không làm việc
                const ctxDaysNotWorked = document.getElementById('daysNotWorkedChart').getContext('2d');
                new Chart(ctxDaysNotWorked, {
                    type: 'bar',
                    data: {
                        labels: employeeNames,
                        datasets: [{
                            label: 'Ngày không làm việc',
                            data: totalDaysNotWorked,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Ngày'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" class="form-inline justify-content-center mt-4">
                <div class="form-group mx-2">
                    <label for="profile_code" class="mr-2">Mã nhân viên:</label>
                    <input type="text" id="profile_code" name="profile_code" class="form-control" required>
                </div>
                <button type="submit" name="view_detail" class="btn btn-primary"><i class="fas fa-search"></i> Xem chi tiết</button>
            </form>
        </div>

        <?php if (!empty($shiftDetails['data'])): ?>
            <h3 class="mt-4">Chi tiết ca làm việc</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Shift ID</th>
                        <th>Tên nhân viên</th>
                        <th>Thời gian vào</th>
                        <th>Thời gian ra</th>
                        <th>Trạng thái vào</th>
                        <th>Trạng thái ra</th>
                        <th>Ca làm thêm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shiftDetails['data'] as $shift): ?>
                        <tr>
                            <td><?php echo $shift['shiftId']; ?></td>
                            <td><?php echo $shift['profileName']; ?></td>
                            <td><?php echo $shift['checkInTime'] ?? 'Chưa vào'; ?></td>
                            <td><?php echo $shift['checkOutTime'] ?? 'Chưa ra'; ?></td>
                            <td><?php echo $shift['checkInStatus'] ?? 'Chưa vào'; ?></td>
                            <td><?php echo $shift['checkOutStatus'] ?? 'Chưa ra'; ?></td>
                            <td><?php echo $shift['isOvertime'] ? 'Có' : 'Không'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
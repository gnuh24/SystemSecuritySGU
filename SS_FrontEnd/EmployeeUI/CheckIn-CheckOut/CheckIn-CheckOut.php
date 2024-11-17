<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Check-In/Check-Out</title>
    <style>
        /* Global styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #4c8bf5, #9b4dff);
            font-family: Arial, sans-serif;
            color: #3a2ecc;
        }

        /* Container styling */
        .container {
            height: 360px;
            background-color: #edf3ff;
            padding: 30px;
            border-radius: 20px;
            width: 500px;
            text-align: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Title */
        h2 {
            position: absolute;
            top: 136px;
            color: #3a2ecc;
            font-size: 32px;
            margin-bottom: 20px;
        }

        /* Input group styling */
        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .input-box {
            background-color: #dcd8f0;
            border-radius: 12px;
            width: 45%;
            color: #6d5a8d;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
        }

        /* Styling for file input */
        .file-input {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            background-color: #6d47cc;
            color: #6d5a8d;
            text-align: center;
            cursor: pointer;
            outline: none;
            box-sizing: border-box;
        }

        .choose-img {
            position: relative;
            top: 0px;
        }

        .file-input::before {
            content: 'Select Fingerprint Image';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            padding: 10px 0;
            color: #6d5a8d;
            background-color: #e1b0ff;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            box-sizing: border-box;
        }


        /* Hide default file input appearance */
        .file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        /* Styling for dropdown */
        .dropdown {
            width: 44%;
            height: 24%;
            padding: 10px;
            font-size: 14px;
            color: #6d5a8d;
            background-color: #e1b0ff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            outline: none;
            box-sizing: border-box;
            margin-top: 10px;
        }

        #dropdown-shifts{
            position: absolute;
            top: 68px;
        }
        #dropdown-employees{
            position: absolute;
            top: 140px;
        }

        /* Button styling */
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            height: 60px;
        }

        .btn {
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            width: 45%;
        }

        .btn-checkin {
            background-color: #4c3ff5;
        }

        .btn-checkin:hover {
            background-color: #3a2ecc;
        }

        .btn-checkout {
            background-color: #8b5aff;
        }

        .btn-checkout:hover {
            background-color: #6d47cc;
        }

        .image {
            height: 200px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

<body style="display: flex; flex-direction: column;">
    <?php include_once '/xampp/htdocs/SystemSecuritySGU/SS_FrontEnd/Header.php'; ?>

    <div class="container">
        <h2>Employee</h2>
        <div class="input-group">
            <div class="input-box ID">Employee's code</div>
            <div class="input-box name">Employee's name</div>
        </div>
        <div class="input-group">
            <label class="input-box choose-img" for="file-input">
                <input type="file" class="file-input" id="file-input" accept="image/*" aria-label="Select Fingerprint Image" onchange="displayImage(event)">
            </label>
            <select class="dropdown" id="dropdown-shifts" aria-label="Select shift">
                <option value="">Select shift</option>
            </select>
            <select class="dropdown" id="dropdown-employees" aria-label="Select Employee">
                <option value="">Select Employee</option>
            </select>
            <div class="input-box image">
                <img id="selectedImage" alt="Selected Image" src="" style="display: none; max-width: 100%; max-height: 100px;">
            </div>
        </div>
        <div class="buttons">
            <button class="btn btn-checkin">Check in</button>
            <button class="btn btn-checkout">Check out</button>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token');
        function displayImage(event) {
            const image = document.getElementById('selectedImage');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }

        document.addEventListener("DOMContentLoaded", () => {
            loadShiftsForToday();
        });

        function loadShiftsForToday(search = '', status = '', pageNumber = 1) {
            const today = new Date();
            const todayDate = today.toISOString().split('T')[0]; // Định dạng YYYY-MM-DD cho ngày hôm nay

            $.ajax({
                url: 'http://localhost:8080/api/Shift/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: search,
                    status: status,
                    pageNumber: pageNumber,
                    pageSize: 10 // hoặc giá trị phù hợp
                },
                headers: {
                    'Authorization': 'Bearer ' + token // Đảm bảo token được định nghĩa
                },
                success: function(response) {

                    const dropdown = $("#dropdown-shifts");
                    dropdown.empty();
                    dropdown.append('<option value="">Select shift</option>');

                    if (response.status === 200 && response.data && response.data.content) {
                        const todayShifts = response.data.content.filter(shift => {
                            if (shift.startTime) {
                                // Trích xuất ngày từ startTime (định dạng hh:mm:ss dd/MM/yyyy)
                                const [timePart, datePart] = shift.startTime.split(' ');
                                const [day, month, year] = datePart.split('/');
                                const formattedShiftDate = `${year}-${month}-${day}`; // Tạo định dạng YYYY-MM-DD

                                return formattedShiftDate === todayDate;
                            }
                            return false;
                        });

                        if (todayShifts.length > 0) {
                            todayShifts.forEach(shift => {
                                dropdown.append(`<option value="${shift.id}">${shift.shiftName}</option>`);
                            });
                        } else {
                            dropdown.append('<option value="">Không có dữ liệu cho hôm nay</option>');
                        }
                    } else {
                        Swal.fire('Lỗi', 'Dữ liệu trả về không đúng định dạng.', 'error');
                    }
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.error ?
                        Object.values(xhr.responseJSON.error).join(", ") :
                        'Không thể tải danh sách ca làm.';
                    Swal.fire('Lỗi', errorMsg, 'error');
                }
            });
        }

        // Hàm để tải danh sách nhân viên trong ca làm đã chọn
        function loadEmployeesForShift(shiftCode) {
            $.ajax({
                url: `http://localhost:8080/api/Shift/Detail?id=${shiftCode}`,
                type: 'GET',
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token // Đảm bảo token được định nghĩa
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        const data = response.data;
                        const employees = data.signUps.map(signUp => signUp.profile);
                        console.log(employees);
                        const dropdown = $("#dropdown-employees");
                        dropdown.empty();
                        dropdown.append('<option value="">Select Employee</option>');

                        // Thêm các tùy chọn nhân viên vào dropdown
                        employees.forEach(employee => {
                            dropdown.append(`<option value="${employee.code}">${employee.fullname}</option>`);
                        });
                    } else {
                        Swal.fire('Lỗi', 'Không thể tải danh sách nhân viên cho ca làm này.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Có lỗi xảy ra khi tải danh sách nhân viên.', 'error');
                }
            });
        }

        $(document).ready(function() {
            // Load danh sách ca làm cho hôm nay
            loadShiftsForToday();

            // Sự kiện khi chọn một ca làm
            $("#dropdown-shifts").on("change", function() {
                const selectedShiftId = $(this).val(); // Lấy ID của ca làm đã chọn
                if (selectedShiftId) {
                    loadEmployeesForShift(selectedShiftId); // Tải danh sách nhân viên cho ca làm đã chọn
                } else {
                    $("#dropdown-employees").empty().append('<option value="">Select Employee</option>'); // Xóa danh sách nhân viên nếu không chọn ca nào
                }
            });
        });

    </script>
</body>
</html>
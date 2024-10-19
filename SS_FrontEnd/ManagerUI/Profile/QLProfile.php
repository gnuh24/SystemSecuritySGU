<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../AdminUI/Admin.css" />
    <link rel="stylesheet" href="../../AdminUI/oneForAll.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Quản lý nhân viên</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            transition: height 0.3s;
            /* Thêm hiệu ứng chuyển đổi khi thay đổi chiều cao */
        }

        th,
        td {
            padding: 1rem;
            border: 1px solid #ddd;
        }

        .modal,
        .modal1 {
            display: none;
            /* Chỉ hiển thị khi cần */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        .modal1 {
            display: flex;
        }



        .modal-content {
            background-color: white;
            /* Màu nền của modal */
            padding: 20px;
            /* Khoảng cách bên trong */
            border-radius: 8px;
            /* Bo tròn góc */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Đổ bóng */
            max-width: 500px;
            /* Chiều rộng tối đa của modal */
            width: 100%;
            /* Chiều rộng 100% */
        }
    </style>
</head>

<body>
    <div id="root">
        <div>
            <div class="App">
                <div class="StaffLayout_wrapper__CegPk">
                    <div>
                        <div>
                            <div class="Manager_wrapper__vOYy">
                                <div style="padding-left: 5%; width: 100%; padding-right: 5%">
                                    <div class="wrapper">
                                        <div style="
                          display: flex;
                          padding-top: 1rem;
                          padding-bottom: 1rem;
                          justify-content: center; 
                            align-items: center;
                            text-align: center;
                        ">
                                            <h2 style="font-size: 7rem; margin: 0; font-family: 'Poppins', sans-serif;">Quản lý nhân viên</h2>
                                        </div>
                                        <div class="Admin_boxFeature__ECXnm">
                                            <div style="position: relative;">
                                                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #007bff;"></i>
                                                <input id="searchInput" class="Admin_input__LtEE-" style="font-family: 'Poppins', sans-serif; padding-left: 35px; padding-right: 10px; border-radius: 1rem;" placeholder="Bạn cần tìm kiếm nhân viên nào?">
                                            </div>
                                            <select id="selectQuyen" style="height: 3rem; padding: 0.3rem; font-family: 'Poppins', sans-serif; border-radius: 1rem;">
                                                <option value="">Trạng thái: tất cả</option>
                                                <option value="true">Active</option>
                                                <option value="false">InActive</option>
                                            </select>

                                            <button id="addNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #7FFF00; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer; width">
                                                <i class="fa-solid fa-plus" style="margin-right: 8px; color: white;"></i>
                                                Thêm nhân viên
                                            </button>

                                            <button id="editNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #B0C4DE; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                                                <i class="fa-solid fa-edit" style="margin-right: 8px; color: white;"></i>
                                                Sửa
                                            </button>

                                            <!-- <button id="deleteNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                                                <i class="fa-solid fa-trash" style="margin-right: 8px; color: white;"></i>
                                                Xóa
                                            </button> -->

                                            <button id="detailsNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #FFA500; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                                                <i class="fa-solid fa-eye" style="margin-right: 8px; color: white;"></i>
                                                Xem chi tiết
                                            </button>
                                        </div>
                                        <div class="modal1" id="addEmployeeModal">
                                            <div class="modal-content">
                                                <h3>Thêm Nhân Viên</h3>

                                                <div class="input-group">
                                                    <i class="fas fa-id-badge"></i>
                                                    <label for="employeeCode"><strong>Mã nhân viên:</strong></label>
                                                    <input type="text" id="employeeCode" required placeholder="Nhập mã nhân viên">
                                                </div>

                                                <div class="input-group">
                                                    <i class="fas fa-user"></i>
                                                    <label for="employeeName"><strong>Tên nhân viên:</strong></label>
                                                    <input type="text" id="employeeName" required placeholder="Nhập tên nhân viên">
                                                </div>

                                                <div class="input-group">
                                                    <i class="fas fa-venus-mars"></i>
                                                    <label for="employeeGender"><strong>Giới tính:</strong></label>
                                                    <select id="employeeGender" required>
                                                        <option value="Male">Nam</option>
                                                        <option value="Female">Nữ</option>
                                                        <option value="Other">Khác</option>
                                                    </select>
                                                </div>

                                                <div class="input-group">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <label for="employeeBirthday"><strong>Ngày sinh:</strong></label>
                                                    <input type="date" id="employeeBirthday" required>
                                                </div>

                                                <div class="input-group">
                                                    <i class="fas fa-phone"></i>
                                                    <label for="employeePhone"><strong>Số điện thoại:</strong></label>
                                                    <input type="text" id="employeePhone" required placeholder="Nhập số điện thoại">
                                                </div>

                                                <div class="input-group">
                                                    <i class="fas fa-envelope"></i>
                                                    <label for="employeeEmail"><strong>Email:</strong></label>
                                                    <input type="email" id="employeeEmail" required placeholder="Nhập email">
                                                </div>

                                                <input type="hidden" id="employeeStatus" value="true">
                                                <input type="hidden" id="createAt">
                                                <input type="hidden" id="updateAt">

                                                <button id="saveEmployee" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu</button>
                                                <button id="closeAddModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                                            </div>
                                        </div>



                                        <div class="Admin_boxTable__hLXRJ">
                                            <table class="Table_table__BWPy" style="border-radius: 1rem;">
                                                <thead class="Table_head__FTUog">
                                                    <tr>
                                                        <th class="Table_th__hCkcg col-small">Mã nhân viên</th>
                                                        <th class="Table_th__hCkcg col-large">Tên nhân viên</th>
                                                        <th class="Table_th__hCkcg col-normal">Email</th>
                                                        <th class="Table_th__hCkcg col-normal">Số điện thoại</th>
                                                        <th class="Table_th__hCkcg col-normal">Trạng thái</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                </tbody>


                                            </table>
                                            <div class="pagination" id="pagination"></div>
                                        </div>
                                        <div class="modal" id="detailsModal">
                                            <div class="modal-content" style="width: 400px; height: auto; border-radius: 10px;">
                                                <h3 style="text-align: center;">Thông tin chi tiết</h3>
                                                <div id="detailsContent" style="text-align: left; padding: 20px;">

                                                </div>
                                                <button id="closeModal" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer; display: block; margin-left: auto; margin-right: auto;">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var currentPage = 1;
        var pageSize = 5;
        var totalPages = 1; // Tổng số trang sẽ được cập nhật từ phản hồi API

        // Hàm gọi API để lấy dữ liệu và hiển thị trên bảng
        function getAllTaiKhoan(search, status, page) {
            $.ajax({
                url: 'http://localhost:8080/api/Profile/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: search,
                    status: status,
                    page: page - 1,
                    size: pageSize
                },
                headers: {
                    'Authorization': 'Bearer ' + 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzI3MDk3MTUwLCJleHAiOjE3Mjk2ODkxNTB9.7rMknTboogqhKHDgy4urBUzlFpGu7BkSOYrEzt8PAjA'
                },
                success: function(response) {
                    $("#tableBody").empty();
                    if (response.status === 200 && response.data) {
                        if (response.data.content.length > 0) {
                            response.data.content.forEach(function(account) {
                                var row = `
                            <tr>
                                <td>${account.code}</td>
                                <td>${account.fullname}</td>
                                <td>${account.email}</td>
                                <td>${account.phone}</td>
                                <td>${account.status === "true" ? 'Active' : 'Inactive'}</td>
                            </tr>
                        `;
                                $("#tableBody").append(row);
                            });
                        } else {
                            $("#tableBody").append('<tr><td colspan="5">Không có dữ liệu</td></tr>');
                        }

                        // Cập nhật phân trang
                        totalPages = response.data.totalPages;
                        renderPagination(currentPage, totalPages);
                    } else {
                        $("#tableBody").append('<tr><td colspan="5">Không có dữ liệu</td></tr>');
                    }
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                    $("#tableBody").empty().append('<tr><td colspan="5">Lỗi khi gọi API</td></tr>');
                }
            });
        }


        function renderPagination(currentPage, totalPages) {
            var paginationHTML = '';

            // Hiển thị nút Previous
            if (currentPage > 1) {
                paginationHTML += `<button onclick="changePage(${currentPage - 1})">Previous</button>`;
            }

            // Hiển thị các trang (mỗi trang là một nút)
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            }

            // Hiển thị nút Next
            if (currentPage < totalPages) {
                paginationHTML += `<button onclick="changePage(${currentPage + 1})">Next</button>`;
            }

            // Cập nhật nội dung phân trang
            $('#pagination').html(paginationHTML);
        }

        // Hàm thay đổi trang
        function changePage(page) {
            if (page < 1 || page > totalPages) {
                return; // Kiểm tra xem trang có hợp lệ không
            }
            currentPage = page;
            getAllTaiKhoan($('#searchInput').val(), $('#selectQuyen').val(), currentPage); // Lấy dữ liệu mới theo trang
        }


        // Hàm thay đổi trang
        function changePage(page) {
            if (page < 1 || page > totalPages) {
                return; // Nếu trang không hợp lệ, thoát ra
            }
            currentPage = page;
            getAllTaiKhoan($('#searchInput').val(), $('#selectQuyen').val(), currentPage);
        }


        // Hàm để thay đổi trang hiện tại
        function changePage(page) {
            if (page < 1 || page > totalPages) {
                return;
            }
            currentPage = page;
            getAllTaiKhoan($('#searchInput').val(), $('#selectQuyen').val(), currentPage);
        }


        function adjustTableHeight(numRows) {
            var table = $(".Table_table__BWPy");
            if (numRows === 0) {
                table.css("height", "50px"); // Đặt chiều cao cho trường hợp không có hàng
            } else if (numRows === 1) {
                table.css("height", "60px"); // Chiều cao cho 1 hàng
            } else if (numRows <= pageSize) {
                table.css("height", "auto"); // Tự động điều chỉnh chiều cao nếu có ít hơn hoặc bằng số hàng tối đa
            } else {
                table.css("height", "auto"); // Tự động điều chỉnh chiều cao nếu có nhiều hơn số hàng tối đa
            }
        }

        $(document).ready(function() {
            getAllTaiKhoan('', '', currentPage);

            $("#searchInput").on("input", function() {
                var searchValue = $(this).val();
                var statusValue = $("#selectQuyen").val();
                getAllTaiKhoan(searchValue, statusValue, currentPage);
            });

            $("#selectQuyen").on("change", function() {
                var searchValue = $("#searchInput").val();
                var statusValue = $(this).val();
                getAllTaiKhoan(searchValue, statusValue, currentPage);
            });

            $("#detailsNV").click(function() {
                const selectedRow = $("tr.selected");
                if (selectedRow.length === 0) {
                    Swal.fire('Chưa chọn nhân viên!', 'Vui lòng chọn một nhân viên để xem chi tiết.', 'warning');
                } else {
                    const employeeCode = selectedRow.find("td").eq(0).text();
                    getEmployeeDetails(employeeCode);
                }
            });

            $("#closeModal").click(function() {
                $("#detailsModal").hide();
            });

            $(document).on('click', 'tr', function() {
                $('tr').removeClass('selected');
                $(this).addClass('selected');
            });

            $("#addNV").click(function() {
                // Mở modal thêm nhân viên
                $("#addEmployeeModal").show();
            });

            $("#closeAddModal").click(function() {
                $("#addEmployeeModal").hide();
            });

            $("#saveEmployee").click(function() {
                const now = new Date();
                const createAt = now.toISOString().split('T')[0] + " 08:00:00";
                const updateAt = createAt;

                const employeeData = {
                    code: $("#employeeCode").val(),
                    fullname: $("#employeeName").val(),
                    gender: $("#employeeGender").val(),
                    birthday: $("#employeeBirthday").val(),
                    phone: $("#employeePhone").val(),
                    email: $("#employeeEmail").val(),
                    status: $("#employeeStatus").val(), // Mặc định là true
                    createAt: createAt,
                    updateAt: updateAt
                };

                // Gọi API để thêm nhân viên mới
                $.ajax({
                    url: 'http://localhost:8080/api/Profile/Create',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(employeeData),
                    headers: {
                        'Authorization': 'Bearer ' + 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzI3MDk3MTUwLCJleHAiOjE3Mjk2ODkxNTB9.7rMknTboogqhKHDgy4urBUzlFpGu7BkSOYrEzt8PAjA'
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire('Thành công', 'Thêm nhân viên thành công!', 'success');
                            $("#addEmployeeModal").hide(); // Đóng modal
                            getAllTaiKhoan('', '', currentPage); // Cập nhật danh sách nhân viên
                        } else {
                            Swal.fire('Lỗi', 'Không thể thêm nhân viên.', 'error');
                        }
                    },
                    error: function() {
                        console.error("Lỗi khi gọi API thêm nhân viên");
                        Swal.fire('Lỗi', 'Có lỗi xảy ra khi thêm nhân viên.', 'error');
                    }
                });
            });

            $("#addNV").click(function() {
                $("#employeeCode").val('');
                $("#employeeName").val('');
                $("#employeeGender").val('Male'); // Mặc định là Nam
                $("#employeeBirthday").val('');
                $("#employeePhone").val('');
                $("#employeeEmail").val('');
                $("#addEmployeeModal").show();
            });

            // Đóng modal
            $("#closeAddModal").click(function() {
                $("#addEmployeeModal").hide();
            });


            $("#editNV").click(function() {
                // Mở modal sửa nhân viên
                alert("Sửa nhân viên");
            });

            $("#deleteNV").click(function() {
                // Xóa nhân viên
                alert("Xóa nhân viên");
            });
        });


        function getEmployeeDetails(employeeCode) {
            $.ajax({
                url: `http://localhost:8080/api/Profile/Detail?code=${employeeCode}`,
                type: 'GET',
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtYW5hZ2VyMDAxIiwiaWF0IjoxNzI3MDk3MTUwLCJleHAiOjE3Mjk2ODkxNTB9.7rMknTboogqhKHDgy4urBUzlFpGu7BkSOYrEzt8PAjA'
                },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        const details = `
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-id-badge" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Mã nhân viên: </strong> ${response.data.code}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-user" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Tên nhân viên: </strong> ${response.data.fullname}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-venus-mars" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Giới tính: </strong> ${response.data.gender}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-calendar-alt" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Ngày sinh: </strong> ${response.data.birthday}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-phone" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Số điện thoại: </strong> ${response.data.phone}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-envelope" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Email: </strong> ${response.data.email}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-check-circle" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Trạng thái: </strong> ${response.data.status ? 'Active' : 'Inactive'}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-clock" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Ngày tạo: </strong> ${response.data.createAt}
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fa-solid fa-clock" style="margin-right: 10px; color: #007bff;"></i>
                        <strong>Ngày cập nhật: </strong> ${response.data.updateAt}
                    </div>
                `;
                        $("#detailsContent").html(details);
                        $("#detailsModal").css("display", "flex");
                    } else {
                        Swal.fire('Lỗi', 'Không tìm thấy thông tin chi tiết.', 'error');
                    }
                },
                error: function() {
                    console.error("Lỗi khi gọi API chi tiết nhân viên");
                    Swal.fire('Lỗi', 'Không thể lấy thông tin chi tiết.', 'error');
                }
            });
        }

        function showModal(modal) {
            modal.style.display = "flex"; // Sử dụng "flex" để căn giữa
        }
    </script>
</body>

</html>
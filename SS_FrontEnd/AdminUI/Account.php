<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./Account.css">
    <link rel=" stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Quản lý tài khoản</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th,
        td {
            padding: 1rem;
            border: 1px solid #ddd;
        }

        .pagination button {
            margin: 0 5px;
            padding: 0.5rem 1rem;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 4rem;
        }

        .pagination button.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Đánh dấu dòng được chọn */
        .selected {
            background-color: #D0E6FF;
            /* Màu nền cho dòng được chọn */
        }
    </style>
</head>

<body>
    <?php include_once '../Header.php'; ?>

        <div style="padding-left: 5%; width: 100%; padding-right: 5%">
            <div style="display: flex; padding-top: 1rem; padding-bottom: 1rem; justify-content: center; align-items: center; text-align: center;">
                <h2 style="font-size: 4rem; margin: 0; font-family: 'Poppins', sans-serif;">Quản lý tài khoản</h2>
            </div>
            
            <div class="Admin_boxFeature__ECXnm">
                <div style="position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #007bff;"></i>
                    <input id="searchInput" class="Admin_input__LtEE-" style="font-family: 'Poppins', sans-serif; padding-left: 35px; padding-right: 10px; border-radius: 1rem;" placeholder="Bạn cần tìm kiếm nhân viên nào?">
                </div>
                <select id="selectStatus" style="height: 3rem; padding: 0.3rem; font-family: 'Poppins', sans-serif; border-radius: 1rem;">
                    <option value="">Trạng thái: tất cả</option>
                    <option value="true">Active</option>
                    <option value="false">Inactive</option>
                </select>
                <button id="searchButton" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                    Tìm kiếm
                    <i class="fa-solid fa-magnifying-glass" style="margin-left: 8px; color: white;"></i>
                </button>
                <button id="editNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #B0C4DE; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                    <i class="fa-solid fa-edit" style="margin-right: 8px; color: white;"></i>
                    Đổi trạng thái
                </button>
            </div>

            <div class="Admin_boxTable__hLXRJ">
                <table class="Table_table__BWPy" style="border-radius: 1rem;">
                    <thead class="Table_head__FTUog">
                        <tr>
                            <th class="Table_th__hCkcg col-small">ID</th>
                            <th class="Table_th__hCkcg col-large">Tên tài khoản</th>
                            <th class="Table_th__hCkcg col-large">Tên nhân viên</th>

                            <th class="Table_th__hCkcg col-large">Email</th>

                            <th class="Table_th__hCkcg col-large">Số điện thoại</th>

                            <th class="Table_th__hCkcg col-normal">Role</th>
                            <th class="Table_th__hCkcg col-normal">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây -->
                    </tbody>
                </table>
                <div class="pagination" id="pagination"></div>
            </div>
        </div>
       

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        const pageSize = 5;
        let currentPage = 1;
        let totalPages = 1;
        const token = localStorage.getItem("token");

        // Khởi tạo danh sách tài khoản khi trang được tải
        $(document).ready(function() {
            getAllTaiKhoan("", "", currentPage);
        });

        function getAllTaiKhoan(search, status, page) {
            $.ajax({
                url: 'http://localhost:8080/api/Account/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: search,
                    status: status,
                    page: page, // Chuyển page để API tính từ 0
                    size: pageSize
                },
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    $("#tableBody").empty();
                    if (response.data.content.length > 0) {
                        response.data.content.forEach(function(account) {
                            var row = `
                                <tr>
                                    <td>${account.id}</td>
                                    <td>${account.username}</td>
                                    <td>${account.profileFullname}</td>
                                    <td>${account.profileEmail}</td>
                                    <td>${account.profilePhone}</td>
                                    <td>${account.role}</td>
                                    <td class="status" data-id="${account.id}" style="cursor: pointer;">${account.status === true ? 'Active' : 'Inactive'}</td>
                                </tr>
                            `;
                            $("#tableBody").append(row);
                        });
                    } else {
                        $("#tableBody").append('<tr><td colspan="7">Không có dữ liệu</td></tr>');
                    }

                    // Cập nhật phân trang
                    totalPages = response.data.totalPages;
                    renderPagination(currentPage, totalPages);
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                    $("#tableBody").empty().append('<tr><td colspan="7">Lỗi khi gọi API</td></tr>');
                }
            });
        }

        function renderPagination(currentPage, totalPages) {
            $("#pagination").empty();
            for (let i = 1; i <= totalPages; i++) {
                let button = `<button class="${i === currentPage ? 'disabled' : ''}" onclick="goToPage(${i})">${i}</button>`;
                $("#pagination").append(button);
            }
        }

        function goToPage(page) {
            if (page !== currentPage && page > 0 && page <= totalPages) {
                currentPage = page;
                searchTaiKhoan();
            }
        }

        function searchTaiKhoan() {
            const search = $("#searchInput").val(); // Lấy giá trị tìm kiếm từ input
            const status = $("#selectStatus").val(); // Lấy trạng thái từ select
            getAllTaiKhoan(search, status, currentPage);
        }

        // Sự kiện cho nút tìm kiếm
        $("#searchButton").on("click", function() {
            currentPage = 1; // Reset trang về 1 khi tìm kiếm
            searchTaiKhoan();
        });

        // Sự kiện cho các dòng trong bảng
        $(document).on("click", "#tableBody tr", function() {
            $(this).toggleClass("selected"); // Thêm hoặc xóa class 'selected'
        });

        $("#editNV").on("click", function() {
            const selectedRows = $("#tableBody tr.selected"); // Lấy các dòng được chọn
            if (selectedRows.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo!',
                    text: 'Vui lòng chọn ít nhất một tài khoản!',
                });
                return;
            }

            // Biến để theo dõi các yêu cầu cập nhật thành công
            let updatePromises = [];

            selectedRows.each(function() {
                const statusCell = $(this).find("td:last-child"); // Lấy ô trạng thái
                const accountId = $(this).find("td:first-child").text().trim(); // Giả sử ID ở cột đầu tiên
                const roleCell = $(this).find("td:nth-child(2)").text().trim(); // Giả sử vai trò ở cột thứ hai
                const currentStatus = statusCell.text().trim() === 'Active'; // Kiểm tra trạng thái hiện tại
                const newStatus = !currentStatus; // Chuyển đổi trạng thái

                // Kiểm tra xem tài khoản có vai trò admin hay không
                if (roleCell.toLowerCase() === 'admin') { // Chuyển đổi thành chữ thường để so sánh chính xác
                    Swal.fire({
                        icon: 'error',
                        title: 'Không được phép!',
                        text: 'Tài khoản admin không thể thay đổi trạng thái!',
                    });
                    return; // Ngừng xử lý nếu vai trò là admin
                }

                // Kiểm tra xem accountId và newStatus có giá trị hợp lệ không
                if (!accountId || newStatus === undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Có lỗi xảy ra khi xác định ID hoặc trạng thái.',
                    });
                    return; // Ngừng xử lý nếu có lỗi
                }

                // Gọi API để cập nhật trạng thái
                // Tạo đối tượng FormData
                const formData = new FormData();
                formData.append('id', parseInt(accountId)); // Thêm id vào FormData
                formData.append('status', newStatus); // Thêm trạng thái mới vào FormData

                const promise = $.ajax({
                    url: 'http://localhost:8080/api/Account/Update',
                    type: 'PATCH', // Sử dụng PATCH
                    data: formData, // Sử dụng FormData thay vì JSON
                    processData: false, // Không xử lý dữ liệu
                    contentType: false, // Không đặt content type (để trình duyệt tự động thiết lập)
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.get("token")
                    }
                });

                promise.done(function(updateResponse) {
                    // Xử lý kết quả từ server
                    console.log("Cập nhật thành công:", updateResponse);
                    if (updateResponse.status === 200) {
                        // Cập nhật lại trạng thái hiển thị
                        statusCell.text(newStatus ? 'Active' : 'Inactive'); // Cập nhật trạng thái hiển thị
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công!',
                            text: updateResponse.message // Sử dụng thông báo từ server
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cập nhật thất bại!',
                            text: updateResponse.message || 'Có lỗi xảy ra khi cập nhật.',
                        });
                    }
                }).fail(function(jqXHR) {
                    console.error("Lỗi khi gọi API cập nhật trạng thái:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi khi gọi API',
                        text: 'Vui lòng kiểm tra lại yêu cầu.',
                    });
                });

                // Thêm promise vào mảng để xử lý đồng thời
                updatePromises.push(promise);
            });

            // Sau khi tất cả các yêu cầu đã được gửi đi
            $.when.apply($, updatePromises).then(function() {
                // Không cần xử lý ở đây nữa vì đã xử lý thành công trong mỗi promise
            });
            console.log("ID:", accountId, "Status:", newStatus);
        });


        
    </script>
</body>

</html>
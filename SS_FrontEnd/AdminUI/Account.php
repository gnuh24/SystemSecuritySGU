<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./Account.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">

    <title>Quản lý tài khoản</title>
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

    </style>
</head>

<body>
    <?php include_once '../Header.php'; ?>

        <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="flex border-b border-gray-200 bg-white" style="height: 44px;" aria-label="Breadcrumb">
        <ol role="list" class="mx-auto flex w-full max-w-screen-xl space-x-4 px-4 sm:px-6 lg:px-8">
            
            <!-- Home breadcrumb -->
            <li class="flex">
            <div class="flex items-center">
                <a  href="/SystemSecuritySGU/SS_FrontEnd/HomePage.php" class="text-gray-400 hover:text-gray-500">
                <!-- Heroicon name: mini/home -->
                <svg 
                    class="flex-shrink-0" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 20 20" 
                    fill="currentColor" 
                    aria-hidden="true"
                    style="width: 20px; height: auto;"
                >
                    <path 
                    fill-rule="evenodd" 
                    d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" 
                    clip-rule="evenodd"
                    />
                </svg>
                <span class="sr-only" >Home</span>
                </a>
            </div>
            </li>

            <!-- Divider and Projects breadcrumb -->
            <li class="flex">
            <div class="flex items-center">
                <svg 
                class="h-full w-6 flex-shrink-0 text-gray-200" 
                viewBox="0 0 24 44" 
                preserveAspectRatio="none" 
                fill="currentColor" 
                xmlns="http://www.w3.org/2000/svg" 
                aria-hidden="true"
                >
                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                </svg>
                <a 
                href="/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php" 
                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                style="font-size: 14px"
                >
                Quản lý tài khoản
                </a>
            </div>
            </li>

            <!-- Divider and Project Nero breadcrumb -->
            <li class="flex">
            <div class="flex items-center" >
                <svg 
                class="h-full w-6 flex-shrink-0 text-gray-200" 
                viewBox="0 0 24 44" 
                preserveAspectRatio="none" 
                fill="currentColor" 
                xmlns="http://www.w3.org/2000/svg" 
                aria-hidden="true"
                >
                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                </svg>
                <a 
                href="#" 
                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" 
                aria-current="page"
                id="shiftName" 
                >
                
                </a>
            </div>
            </li>

        </ol>
    </nav>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="sm:flex-auto mt-1">
            <h1 style="font-size: 20px;" class="font-semibold text-gray-900">Tài khoản</h1>
            <p class="mt-2 text-gray-700">
                Danh sách tất cả tài khoản 
            </p>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="w-2/3 relative">
                <i style="top: 18px; left: 5px;" class="fa-solid fa-magnifying-glass text-blue-500 absolute transform -translate-y-1/2"></i>
                <input id="searchInput" class="w-full pl-10 pr-3 py-2 border rounded-lg font-sans" placeholder="Bạn cần tìm kiếm nhân viên nào?" />
            </div>


            <select id="selectQuyen" class="p-2 border rounded-lg font-sans">
                <option value="">Trạng thái: tất cả</option>
                <option value="true">Active</option>
                <option value="false">InActive</option>
            </select>
        </div>

        
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        style="width: 10%;"
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center"
                                    >
                                        Mã tài khoản
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left sm:pl-6 text-center"
                                    >
                                        Tên tài khoản
                                    </th>
                                    <th
                                    style="width: 25%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center"
                                    >
                                        Tên người sở hữu
                                    </th>
                                    <th
                                    style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center"
                                    >
                                        Trạng thái
                                    </th>
                                    <th
                                    style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center"
                                    >
                                        Role
                                    </th>
                                    <th
                                    style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="divide-y divide-gray-200 bg-white">
                                

                            </tbody>
                        </table>
                        <div id="pagination-container"></div>

                    </div>
                </div>
            </div>
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
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        <div class="font-medium text-gray-900">
                                            ${account.code}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center ml-12">
                                            <div class="h-20 w-20 flex-shrink-0">
                                                <img
                                                    class="h-20 w-20 rounded-full"
                                                    src="${'/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/16b2e2579118bf6fba3b56523583117f.jpg'}"
                                                    alt="${account.username}"
                                                />
                                            </div>
                                            <div style="margin-left: 20%;">
                                                <div class="font-medium text-gray-900">
                                                    ${account.username}
                                                </div>
                                                <div class="text-gray-500">
                                                    ${account.profileEmail}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${account.profileFullname}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4">
                                        <span class="inline-flex rounded-full ${account.status === 'true' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 font-semibold leading-5">
                                            ${account.status === 'true' ? 'Active' : 'Inactive'}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${account.role ? account.role : 'Manager'}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-blue-800" onclick="event.stopPropagation(); window.location.href = './UpdateProfileForm.php?code=${account.code}';">
                                        Edit
                                    </td>
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
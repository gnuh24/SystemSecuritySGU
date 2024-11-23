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

        
        .paginationjs {
            display: flex;
            justify-content: center;
            padding: 20px 0;
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
       
    <script>
        const pageSize = 5;
        let currentPage = 1;
        let totalPages = 1;
        const token = localStorage.getItem("token");

        var search = "";
        var status = "";

        // Khởi tạo danh sách tài khoản khi trang được tải
        $(document).ready(function() {
            getAllTaiKhoan(currentPage);
        });

        function getAllTaiKhoan(page) {
            $.ajax({
                url: 'http://localhost:8080/api/Account/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: search,
                    status: status,
                    pageNumber: page, // Chuyển page để API tính từ 0
                    pageSize: pageSize
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
                                            ${account.id}
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
                                        <span class="inline-flex rounded-full ${account.status === true || account.status === 'true' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 font-semibold leading-5">
                                            ${account.status === true || account.status === 'true' ? 'Active' : 'Inactive'}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${account.role ? account.role : 'Manager'}
                                    </td>
                                   <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-blue-800">
                                        <!-- Render button only if role is not Admin -->
                                        ${account.role !== 'Admin' ? `
                                            <button 
                                                class="px-3 py-2 text-white font-medium rounded" 
                                                onclick="event.stopPropagation(); handleButtonClick('${account.id}', '${account.status}');"
                                                style="background-color: ${account.status === true ? 'red' : 'green'};">
                                                ${account.status === true ? 'Khóa' : 'Mở khóa'}
                                            </button>
                                        ` : ''}
                                    </td>
                                </tr>
                                `;


                            $("#tableBody").append(row);
                        });
                    } else {
                        $("#tableBody").append('<tr><td colspan="7">Không có dữ liệu</td></tr>');
                    }

                    
                    setupPagination(response.data.totalElements, page)
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                    $("#tableBody").empty().append('<tr><td colspan="7">Lỗi khi gọi API</td></tr>');
                }
            });
        }

        // Sự kiện cho nút tìm kiếm
        $("#selectQuyen").on("change", function() {
            currentPage = 1; // Reset trang về 1 khi tìm kiếm
            status = $("#selectQuyen").val(); // Lấy giá trị tìm kiếm từ input
            getAllTaiKhoan(currentPage);
        });


        // Sự kiện cho nút tìm kiếm
        $("#searchInput").on("change", function() {
            currentPage = 1; // Reset trang về 1 khi tìm kiếm
            search = $("#searchInput").val(); // Lấy giá trị tìm kiếm từ input
            getAllTaiKhoan(currentPage);
        });

        function setupPagination(totalElements, currentPage) {

            //Kiểm tra xem nếu totalPage ít hơn 1 thì ẩn luôn =))
            const totalPage = Math.ceil(totalElements / pageSize);
            totalPage <= 1 ? $('#pagination-container').hide() : $('#pagination-container').show();

            $('#pagination-container').pagination({
                dataSource: Array.from({
                    length: totalElements
                }, (_, i) => i + 1),

                pageSize: pageSize,
                showPrevious: true,
                showNext: true,
                pageNumber: currentPage,

                callback: function(data, pagination) {
                    if (pagination.pageNumber !== currentPage) {
                        currentPage = pagination.pageNumber; 
                        getAllTaiKhoan(currentPage);
                    }
                }
            });
        }

        // Function to handle button click
        function handleButtonClick(accountId, currentStatus) {
            // Determine the new status
            const newStatus = currentStatus === 'true' ? 'false' : 'true';

            // Call the update function with accountId and newStatus
            update(accountId, newStatus);
        }

        // Mock update function for demonstration
        function update(accountId, status) {
            $.ajax({
                url: 'http://localhost:8080/api/Account/Update',
                type: 'PATCH',
                dataType: "json",
                data: {
                    id: accountId,
                    status: status,
                },
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    getAllTaiKhoan(currentPage);
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                }
            });
        }



        
    </script>
</body>

</html>
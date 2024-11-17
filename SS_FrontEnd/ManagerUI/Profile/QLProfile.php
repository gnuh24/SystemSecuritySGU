<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../AdminUI/Account.css" />
    <link rel="stylesheet" href="./QLProfile.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">

    <title>Quản lý nhân sự</title>

</head>
<style>
    .paginationjs {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }
</style>
<body>
    <?php include_once '/xampp/htdocs/SystemSecuritySGU/SS_FrontEnd/Header.php'; ?>

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
                class="ml-4 font-medium text-gray-500 hover:text-gray-700"
                style="font-size: 14px"
                >
                Quản lý nhân sự
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
                class="ml-4 font-medium text-gray-500 hover:text-gray-700" 
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
        <div class="sm:flex sm:items-center">
            <!-- <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Users</h1>
                <p class="mt-2 text-gray-700">
                    A list of all the users in your account including their name, title,
                    email and role.
                </p>
            </div> -->
            <div class="relative w-1/2">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-500"></i>
                <input id="searchInput" class="w-full pl-10 pr-3 py-2 border rounded-lg font-sans" placeholder="Bạn cần tìm kiếm nhân viên nào?" />
            </div>

            <select id="selectQuyen" class="h-12 p-2 border rounded-lg font-sans">
                <option value="">Trạng thái: tất cả</option>
                <option value="true">Active</option>
                <option value="false">InActive</option>
            </select>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                    id="addNV"
                    type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                >
                    Add user
                </button>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left font-semibold text-gray-900 text-center"
                                    >
                                        Mã nhân viên 
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6 text-center"
                                    >
                                        Họ và tên
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left font-semibold text-gray-900 text-center"
                                    >
                                        Trạng thái
                                    </th>
                                    
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left font-semibold text-gray-900 text-center"
                                    >
                                        Trạng thái
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left font-semibold text-gray-900 text-center"
                                    >
                                        Vị trí
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left font-semibold text-gray-900 text-center"
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
        var currentPage = 1;
        var pageSize = 5;
        var totalPages = 1;
        var search = "";
        var status = "";
        const token = localStorage.getItem('token');

        $(document).ready(function() {
            getAllTaiKhoan(currentPage);

            $("#searchInput").on("input", function() {
                search = $(this).val();
                getAllTaiKhoan(currentPage);
            });

            $("#selectQuyen").on("change", function() {
                status = $(this).val();
                getAllTaiKhoan(currentPage);
            });
        });

        // Hàm gọi API để lấy dữ liệu và hiển thị trên bảng
        function getAllTaiKhoan(pageNumber) {
            var searchConverted = removeAccentsAndToLowerCase(search);
            $.ajax({
                url: 'http://localhost:8080/api/Profile/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: searchConverted,
                    status: status,
                    pageNumber: pageNumber,
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
                                <tr onclick="window.location.href='./DetailProfileForm.php?code=${account.code}'">                  
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        <div class="font-medium text-gray-900">
                                                ${account.code}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-20 w-20 flex-shrink-0">
                                                <img
                                                    class="h-20 w-20 rounded-full"
                                                    src="${'/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/16b2e2579118bf6fba3b56523583117f.jpg'}"
                                                    alt="${account.fullname}"
                                                />
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">
                                                    ${account.fullname}
                                                </div>
                                                <div class="text-gray-500">
                                                    ${account.email}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${account.phone}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4">
                                        <span class="inline-flex rounded-full ${account.status === "true" ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 font-semibold leading-5">
                                            ${account.status === "true" ? 'Active' : 'Inactive'}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${account.position ? account.position : 'Member'}
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right font-medium sm:pr-6">
                                        <a href="./UpdateProfileForm.php?code=${account.code}" class="text-indigo-600 hover:text-indigo-900">
                                            Edit<span class="sr-only">, ${account.fullname}</span>
                                        </a>
                                    </td>
                                </tr>
                            `;
                            $("#tableBody").append(row);
                        });

                    } else {
                        $("#tableBody").append('<tr><td colspan="5" class="text-center py-4 text-base">Không có dữ liệu</td></tr>');
                    }

                    setupPagination(response.data.totalElements, pageNumber);  
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                    $("#tableBody").empty().append('<tr><td colspan="5" class="text-center py-4 text-base">Lỗi khi gọi API</td></tr>');
                }
            });
        }
    

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

        function removeAccentsAndToLowerCase(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        
    </script>
        
</body>
</html>
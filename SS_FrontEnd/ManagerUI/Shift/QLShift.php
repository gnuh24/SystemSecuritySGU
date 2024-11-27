<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../AdminUI/shift.css" />
    <link rel="stylesheet" href="./QLShift.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Quản lý ca làm mơi</title>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>

</head>

<style>
    .paginationjs {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }
</style>

<body style="display: flex; flex-direction:column">

    <?php include_once '/xampp/htdocs/SystemSecuritySGU/SS_FrontEnd/Header.php'; ?>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="flex border-b border-gray-200 bg-white" style="height: 44px;" aria-label="Breadcrumb">
        <ol role="list" class="mx-auto flex w-full max-w-screen-xl space-x-4 px-4 sm:px-6 lg:px-8">

            <!-- Home breadcrumb -->
            <li class="flex">
                <div class="flex items-center">
                    <a href="/SystemSecuritySGU/SS_FrontEnd/HomePage.php" class="text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: mini/home -->
                        <svg
                            class="flex-shrink-0"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                            style="width: 20px; height: auto;">
                            <path
                                fill-rule="evenodd"
                                d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Home</span>
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
                        aria-hidden="true">
                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                    </svg>
                    <a
                        href="/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php"
                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                        style="font-size: 14px">
                        Quản lý ca làm
                    </a>
                </div>
            </li>

            <!-- Divider and Project Nero breadcrumb -->
            <li class="flex">
                <div class="flex items-center">
                    <svg
                        class="h-full w-6 flex-shrink-0 text-gray-200"
                        viewBox="0 0 24 44"
                        preserveAspectRatio="none"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                    </svg>
                    <a
                        href="#"
                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                        aria-current="page"
                        id="shiftName">

                    </a>
                </div>
            </li>

        </ol>
    </nav>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="sm:flex-auto mt-1">
            <h1 style="font-size: 20px;" class="font-semibold text-gray-900">Ca làm</h1>
            <p class="mt-2 text-gray-700">
                Danh sách tất cả các ca làm trên hệ thống
            </p>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="w-2/3 relative">
                <i style="top: 18px; left: 5px;" class="fa-solid fa-magnifying-glass text-blue-500 absolute transform -translate-y-1/2"></i>
                <input id="searchInput" class="w-full pl-10 pr-3 py-2 border rounded-lg font-sans" placeholder="Bạn cần tìm kiếm ca làm nào?" />
            </div>

            <select id="selectCategory" class="p-2 border rounded-lg font-sans">
                <option value="">Loại ca làm: Tất cả</option>
                <option value="true">OT</option>
                <option value="false">Tiêu chuẩn</option>
            </select>


            <select id="selectStatus" class="p-2 border rounded-lg font-sans">
                <option value="">Trạng thái: tất cả</option>
                <option value="true">Active</option>
                <option value="false">InActive</option>
            </select>

            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                    id="addNV"
                    type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm sm:w-auto"
                    onclick="window.location.href='./CreateShiftForm.php'">
                    Thêm ca làm
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
                                        style="width: 10%;"
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        ID
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left sm:pl-6 text-center">
                                        Tên ca làm
                                    </th>
                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Thời gian bắt đầu
                                    </th>

                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Thời gian kết thúc
                                    </th>
                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Bắt đầu giờ nghỉ
                                    </th>
                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Kết thúc giờ nghỉ
                                    </th>
                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Loại ca làm
                                    </th>
                                    <th
                                        style="width: 10%;"

                                        scope="col"
                                        class="px-3 py-3.5 text-left text-center">
                                        Trạng thái
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
        var category = "";
        const token = localStorage.getItem('token');

        $(document).ready(function() {
            getAllTaiKhoan(currentPage);

            $("#searchInput").on("input", function() {
                search = $(this).val();
                getAllTaiKhoan(currentPage);
            });

            $("#selectCategory").on("change", function() {
                category = $(this).val();
                getAllTaiKhoan(currentPage);
            });

            $("#selectStatus").on("change", function() {
                status = $(this).val();
                getAllTaiKhoan(currentPage);
            });
        });

        // Hàm gọi API để lấy dữ liệu và hiển thị trên bảng
        function getAllTaiKhoan(pageNumber) {
            var searchConverted = removeAccentsAndToLowerCase(search);
            $.ajax({
                url: 'http://localhost:8080/api/Shift/List',
                type: 'GET',
                dataType: "json",
                data: {
                    search: searchConverted,
                    isActive: status,
                    isOT: category,
                    pageNumber: pageNumber,
                    pageSize: pageSize
                },
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    $("#tableBody").empty();
                    if (response.data.content.length > 0) {
                        response.data.content.forEach(function(shift) {
                            var row = `
                                <tr onclick="window.location.href='./ShiftInDetail.php?shiftId=${shift.id}'">                   
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        <div class="font-medium text-gray-900">
                                            ${shift.id}
                                        </div>
                                    </td>
                                    <td class="flex items-center justify-center whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex-row items-center justify-center">
                                            <div class="font-medium text-gray-900">
                                                ${shift.shiftName}
                                            </div>
                                            <div class="text-gray-500">
                                                <span class="inline-flex rounded-full ${shift.isActive === true ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 font-semibold leading-5">
                                                    ${shift.isActive === true ? 'Active' : 'Inactive'}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${shift.startTime}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${shift.endTime}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${shift.breakStartTime?shift.breakStartTime:'N/A'}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        ${shift.breakEndTime?shift.breakEndTime:'N/A'}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        <span class="inline-flex rounded-full ${shift.isOT === false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 font-semibold leading-5">
                                            ${shift.isOT === false ?  'Tiêu chuẩn': 'OT'}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-blue-800" onclick="event.stopPropagation(); window.location.href = './UpdateShiftForm.php?shiftId=${shift.id}';">
                                        Edit
                                    </td>
                                </tr>
                            `;


                            $("#tableBody").append(row);
                        });

                    } else {
                        $("#tableBody").append('<tr><td colspan="6" class="text-center py-4 text-base">Không có dữ liệu</td></tr>');
                    }

                    setupPagination(response.data.totalElements, pageNumber);
                },
                error: function() {
                    console.error("Lỗi khi gọi API");
                    $("#tableBody").empty().append('<tr><td colspan="6" class="text-center py-4 text-base">Lỗi khi gọi API</td></tr>');
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
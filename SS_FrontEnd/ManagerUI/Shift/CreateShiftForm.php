<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">
    <title>Thêm ca làm</title>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/paginationjs@2.1.5/dist/pagination.css" />
    <script src="https://cdn.jsdelivr.net/npm/paginationjs@2.1.5/dist/pagination.min.js"></script>

</head>
<style>
    #closeButton {

        float: left;
        /* Cách cạnh phải 10px */
        width: 30px;
        /* Kích thước nút */
        height: 30px;
        /* Màu nền đỏ với độ trong suốt */
        color: white;
        /* Màu chữ */
        font-weight: bold;
        font-size: 18px;
        text-align: center;
        /* Căn giữa chữ */
        line-height: 30px;
        /* Để chữ nằm giữa nút */
        border-radius: 50%;
        /* Bo tròn nút */
        cursor: pointer;
        /* Đổi con trỏ khi hover */
        transition: background-color 0.3s ease;
        /* Hiệu ứng mượt khi hover */
    }

    #closeButton:hover {
        background-color: rgba(255, 0, 0, 1);
        /* Đậm màu hơn khi hover */
    }

    .paginationjs {
        display: flex;
        justify-content: center;
    }

    input,
    select,
    option {
        text-indent: 15px;
        height: 35px;
        border: 1px solid black;

    }

    button {
        background: linear-gradient(135deg, #67a5e5, #9b59b6) !important;
    }

    .bg-red-500 {
        background-color: red !important;
    }

    #employeeList {
        width: 100%;
        height: 100%;
        background-color: rgba(103, 165, 229, 0.8);
        /* Màu nền với độ trong suốt */

    }
</style>

<body class="bg-gray-100">

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
                        class="ml-4 font-medium text-gray-500 hover:text-gray-700"
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
                        class="ml-4 font-medium text-gray-500 hover:text-gray-700"
                        aria-current="page"
                        id="profileCodeBreadcrumb">
                        Thêm ca làm mới
                    </a>
                </div>
            </li>

        </ol>
    </nav>

    <div class="m-20 my-8 p-12 py-8 bg-white rounded-lg shadow-lg">
        <form>
            <h2 class="text-base/7 font-semibold text-gray-900">Thông tin ca làm</h2>

            <div class="border-b border-gray-900/10 pb-12 mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <div class="sm:col-span-2">
                    <label for="shiftName" class="block text-sm/6 font-medium text-gray-900">Tên ca làm</label>
                    <div class="mt-2">
                        <input type="text" name="shiftName" id="shiftName" autocomplete="family-name" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm/6 font-medium text-gray-900">Tình trạng</label>
                    <div class="mt-2">
                        <select name="status" id="status" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            <option value="1">Kích hoạt</option>
                            <option value="0">Vô hiệu hóa</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="isOT" class="block text-sm/6 font-medium text-gray-900">Loại ca làm</label>
                    <div class="mt-2">
                        <select name="isOT" id="isOT" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" onchange="toggleBreakFields()">
                            <option value="0">Tiêu chuẩn</option>
                            <option value="1">OT</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="startTime" class="block text-sm/6 font-medium text-gray-900">Thời gian vào ca</label>
                    <div class="mt-2">
                        <input type="text" id="startTime" class="block w-full rounded-md py-2 px-3 text-gray-900 shadow-sm ring-1 ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="endTime" class="block text-sm/6 font-medium text-gray-900">Thời gian tan ca</label>
                    <div class="mt-2">
                        <input type="text" id="endTime" class="block w-full rounded-md py-2 px-3 text-gray-900 shadow-sm ring-1 ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                    </div>
                </div>

                <!-- Thời gian nghỉ giải lao -->
                <div class="sm:col-span-3" id="breakFields" style="display: block;">
                    <label for="breakStartTime" class="block text-sm/6 font-medium text-gray-900">Thời gian nghỉ giải lao</label>
                    <div class="mt-2">
                        <input type="text" id="breakStartTime" class="block w-full rounded-md py-2 px-3 text-gray-900 shadow-sm ring-1 ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                    </div>
                </div>

                <div class="sm:col-span-3" id="breakEndField" style="display: block;">
                    <label for="breakEndTime" class="block text-sm/6 font-medium text-gray-900">Thời gian trở lại ca làm</label>
                    <div class="mt-2">
                        <input type="text" id="breakEndTime" class="block w-full rounded-md py-2 px-3 text-gray-900 shadow-sm ring-1 ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                    </div>
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
                                            Mã nhân viên
                                        </th>
                                        <th style="width: 10%;"
                                            scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left sm:pl-6 text-center">
                                            Họ và tên
                                        </th>
                                        <th
                                            style="width: 10%;"
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-center">
                                            Số điện thoại
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="tableBody_1" class="divide-y divide-gray-200 bg-white">


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-around">
                <button type="button" class="w-1/5 text-white py-2 px-4 rounded-md" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php';">
                    Quay lại
                </button>
                <button type="button" class="w-1/5 text-white py-2 px-4 rounded-md" id="showListButton">
                    Chọn danh sách
                </button>
                <button type="button" class="w-1/5 text-white py-2 px-4 rounded-md" id="createButton">
                    Tạo ca làm
                </button>
            </div>
        </form>
    </div>
    <div class="mt-8 flex flex-col hidden" id="employeeList">
        <div style="width:100%;display:flex;justify-content:flex-end;">
            <div id="closeButton">X</div>
        </div>
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th style="width: 10%;" class="px-3 py-3.5 text-left text-center">Mã nhân viên</th>
                                <th class="py-3.5 pl-4 pr-3 text-left sm:pl-6 text-center">Họ và tên</th>
                                <th style="width: 10%;" class="px-3 py-3.5 text-left text-center">Số điện thoại</th>
                                <th style="width: 10%;" class="px-3 py-3.5 text-left text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200 bg-white">
                            <!-- Nội dung danh sách -->
                        </tbody>
                    </table>
                    <div id="pagination-container"></div>

                </div>
            </div>
        </div>
    </div>
</body>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
<script>
    document.getElementById("closeButton").addEventListener("click", function() {
        const employeeList = document.getElementById("employeeList");
        employeeList.classList.add("hidden"); // Ẩn danh sách khi nhấn nút X
    });

    var currentPage = 1;
    var pageSize = 5;
    var totalPages = 1;
    var search = "";
    var status = "";
    const token = localStorage.getItem('token');
    document.getElementById("showListButton").addEventListener("click", function() {
        const employeeList = document.getElementById("employeeList");
        if (employeeList.classList.contains("hidden")) {
            employeeList.classList.remove("hidden");

            // Căn giữa màn hình
            employeeList.style.position = "fixed"; // Cố định trong màn hình
            employeeList.style.top = "50%"; // Căn giữa theo chiều dọc
            employeeList.style.left = "50%"; // Căn giữa theo chiều ngang
            employeeList.style.transform = "translate(-50%, -50%)"; // Dịch chuyển để căn giữa tuyệt đối
            employeeList.style.zIndex = "1000"; // Hiện ở trên cùng

        } else {
            employeeList.classList.add("hidden"); // Ẩn danh sách khi nhấn lại
        }
    });


    $(document).ready(function() {
        getAllTaiKhoan(currentPage);


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
                status: 1,
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
                        <tr>                   
                            <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-center">
                                <div class="font-medium text-gray-900">
                                    ${account.code}
                                </div>
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6 text-center">
                                <div class="flex items-center ml-12">
                                    <div class="h-20 w-20 flex-shrink-0">
                                        <img
                                            class="h-20 w-20 rounded-full"
                                            src="${'/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/16b2e2579118bf6fba3b56523583117f.jpg'}"
                                            alt="${account.fullname}"
                                        />
                                    </div>
                                    <div style="margin-left: 20%;">
                                        <div class="font-medium text-gray-900">
                                            ${account.fullname}
                                        </div>
                                        <div class="text-gray-500">
                                            ${account.email}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-center">
                                ${account.phone}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-gray-500 text-center">
                                <input type="checkbox" id="closeCheckbox_${account.code}" ${isChecked(account.code) ? 'checked' : ''}>
                            </td>
                        </tr>
                    `;

                        $("#tableBody").append(row);

                        // Gán sự kiện cho mỗi checkbox
                        $("#closeCheckbox_" + account.code).on('change', function() {
                            const isCheckedState = $(this).prop('checked');
                            if (isCheckedState) {
                                saveCheckboxState(account.code, account); // Lưu thông tin vào localStorage
                                addRowToTable(account); // Thêm dòng vào bảng #tableBody_1
                            } else {
                                removeCheckboxState(account.code); // Xóa thông tin khỏi localStorage
                                removeRowFromTable(account.code); // Xóa dòng khỏi bảng #tableBody_1
                            }
                        });
                    });
                } else {
                    $("#tableBody").append('<tr><td colspan="6" class="text-center py-4 text-base">Không có dữ liệu</td></tr>');
                }

                setupPagination(response.data.totalElements, pageNumber);

                // Sau khi trang được tải, kiểm tra trạng thái checkbox từ localStorage và cập nhật bảng #tableBody_1
                loadCheckedAccounts();
            },
            error: function() {
                console.error("Lỗi khi gọi API");
                $("#tableBody").empty().append('<tr><td colspan="6" class="text-center py-4 text-base">Lỗi khi gọi API</td></tr>');
            }
        });
    }

    // Lưu trạng thái checkbox vào localStorage
    function saveCheckboxState(code, account) {
        let storedData = JSON.parse(localStorage.getItem('checkboxState')) || {};
        storedData[code] = account; // Lưu thông tin đầy đủ của account
        localStorage.setItem('checkboxState', JSON.stringify(storedData));
    }

    // Xóa trạng thái checkbox khỏi localStorage
    function removeCheckboxState(code) {
        let storedData = JSON.parse(localStorage.getItem('checkboxState')) || {};
        delete storedData[code]; // Xóa thông tin account với mã nhân viên tương ứng
        localStorage.setItem('checkboxState', JSON.stringify(storedData));
    }

    // Kiểm tra trạng thái checkbox từ localStorage
    function isChecked(code) {
        let storedData = JSON.parse(localStorage.getItem('checkboxState')) || {};
        return storedData[code] ? true : false; // Trả về true nếu checkbox được lưu, false nếu không
    }

    // Thêm dòng vào bảng #tableBody_1
    function addRowToTable(account) {
        var row = `
        <tr id="row_${account.code}">
            <td class="px-3 py-4 text-gray-500 text-center">${account.code}</td>
            <td class="px-3 py-4 text-gray-500 text-center">${account.fullname}</td>
            <td class="px-3 py-4 text-gray-500 text-center">${account.phone}</td>
           
        </tr>
    `;
        $("#tableBody_1").append(row);
    }



    // Xóa dòng khỏi bảng #tableBody_1
    function removeRowFromTable(code) {
        $("#row_" + code).remove();
    }

    // Hàm xem thông tin chi tiết (tùy chọn)
    function viewProfile(code) {
        window.location.href = `./DetailProfileForm.php?code=${code}`;
    }

    // Tải các tài khoản đã chọn từ localStorage và hiển thị chúng trong bảng #tableBody_1
    function loadCheckedAccounts() {
        let storedData = JSON.parse(localStorage.getItem('checkboxState')) || {};
        for (let code in storedData) {
            addRowToTable(storedData[code]); // Thêm dòng vào bảng #tableBody_1 cho mỗi tài khoản đã lưu
        }
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

    function toggleBreakFields() {
        const isOT = document.getElementById('isOT').value;
        const breakFields = document.getElementById('breakFields');
        const breakEndField = document.getElementById('breakEndField');

        if (isOT === '1') { // Nếu chọn OT
            breakFields.style.display = 'none';
            breakEndField.style.display = 'none';
        } else { // Nếu chọn Tiêu chuẩn
            breakFields.style.display = 'block';
            breakEndField.style.display = 'block';
        }
    }

    // Flatpickr JS
    const commonConfig = {
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        time_24hr: true
    };

    flatpickr("#startTime", commonConfig);
    flatpickr("#endTime", commonConfig);
    flatpickr("#breakStartTime", commonConfig);
    flatpickr("#breakEndTime", commonConfig);



    async function validateForm() {
        const shiftName = document.getElementById("shiftName").value.trim();
        const status = document.getElementById("status").value;
        const isOT = document.getElementById("isOT").value;
        const startTime = document.getElementById("startTime").value.trim();
        const endTime = document.getElementById("endTime").value.trim();
        const breakStartTime = document.getElementById("breakStartTime").value.trim();
        const breakEndTime = document.getElementById("breakEndTime").value.trim();

        const now = new Date();

        // Kiểm tra các trường cơ bản
        if (!shiftName) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Tên ca làm không được để trống!'
            });
            return false;
        }
        if (!startTime) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Thời gian vào ca không được để trống!'
            });
            return false;
        }
        if (!endTime) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Thời gian tan ca không được để trống!'
            });
            return false;
        }

        // Kiểm tra danh sách nhân viên
        const profileCodes = localStorage.getItem("checkboxState");
        console.log(profileCodes)
        if (!profileCodes) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Danh sách nhân viên không được để trống!'
            });
            return false;

        }

        // Chuyển đổi các thời gian thành đối tượng Date
        const start = new Date(startTime);
        const end = new Date(endTime);
        const breakStart = breakStartTime ? new Date(breakStartTime) : null;
        const breakEnd = breakEndTime ? new Date(breakEndTime) : null;

        // Kiểm tra thời gian phải ở tương lai
        if (start <= now) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Thời gian vào ca phải nằm trong tương lai!'
            });
            return false;
        }

        if (end <= now) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Thời gian tan ca phải nằm trong tương lai!'
            });
            return false;
        }

        // Kiểm tra thời gian tan ca lớn hơn thời gian vào ca
        if (start >= end) {
            await Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Thời gian tan ca phải lớn hơn thời gian vào ca!'
            });
            return false;
        }

        // Nếu là OT, kiểm tra thời gian nghỉ giải lao
        if (isOT !== "1") {
            if (!breakStartTime || !breakEndTime) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Thời gian nghỉ giải lao và trở lại không được để trống nếu là OT!'
                });
                return false;
            }

            // Kiểm tra thời gian nghỉ giải lao nằm trong thời gian ca làm
            if (breakStart <= start || breakEnd >= end || breakStart >= breakEnd) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Thời gian nghỉ giải lao phải nằm giữa thời gian vào ca và tan ca!'
                });
                return false;
            }

            // Kiểm tra thời gian nghỉ giải lao ở tương lai
            if (breakStart <= now || breakEnd <= now) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Thời gian nghỉ giải lao phải nằm trong tương lai!'
                });
                return false;
            }
        }

        return true;
    }




    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("createButton").addEventListener("click", async function() {
            const isValid = await validateForm();
            if (isValid) {
                callAPICreateShift();
            }
        });
    });


    function convertToISOFormat(dateTime) {
        // Chuyển đổi chuỗi thành đối tượng Date
        const dateObj = new Date(dateTime.replace(" ", "T"));

        // Tạo các giá trị năm, tháng, ngày, giờ và phút
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
        const day = String(dateObj.getDate()).padStart(2, '0');
        const hours = String(dateObj.getHours()).padStart(2, '0');
        const minutes = String(dateObj.getMinutes()).padStart(2, '0');
        const seconds = String(dateObj.getSeconds()).padStart(2, '0');

        // Tạo chuỗi định dạng ISO
        return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
    }



    function callAPICreateShift() {
        // Create FormData object to send only the required fields
        let formData = new FormData();

        // Get values from the form
        const shiftName = document.getElementById("shiftName").value.trim();
        formData.append("shiftName", shiftName);

        const status = document.getElementById("status").value;
        formData.append("isActive", status);

        const isOT = document.getElementById("isOT").value;
        formData.append("isOT", isOT);

        const startTime = document.getElementById("startTime").value.trim();
        formData.append("startTime", convertToISOFormat(startTime));

        const endTime = document.getElementById("endTime").value.trim();
        formData.append("endTime", convertToISOFormat(endTime));

        // Include break times only if `isOT` is set to "1"
        if (isOT !== "1") {
            const breakStartTime = document.getElementById("breakStartTime").value.trim();
            formData.append("breakStartTime", convertToISOFormat(breakStartTime));

            const breakEndTime = document.getElementById("breakEndTime").value.trim();
            formData.append("breakEndTime", convertToISOFormat(breakEndTime));
        }

        // Retrieve the list of profileCodes from localStorage
        const profileCodes = JSON.parse(localStorage.getItem("checkboxState"));

        // Kiểm tra nếu có dữ liệu trong localStorage
        if (profileCodes && typeof profileCodes === 'object') {
            // Lấy danh sách các mã nhân viên từ đối tượng profileCodes
            const codesArray = Object.keys(profileCodes); // Lấy các mã nhân viên từ các khóa (mã nhân viên)

            // Chuyển đổi mảng mã nhân viên thành chuỗi, phân tách bằng dấu phẩy
            const codesString = codesArray.join(',');

            // Gửi chuỗi mã nhân viên
            formData.append("profileCodes", codesString);
        } else {
            // Nếu không có mã nhân viên nào, gửi chuỗi rỗng
            formData.append("profileCodes", "");
        }


        // Send the data via AJAX request
        $.ajax({
            url: 'http://localhost:8080/api/Shift/Create', // Ensure this matches the correct endpoint
            method: 'POST',
            data: formData,
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token // Assuming `token` is defined elsewhere
            },
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Let the browser set the content type
            beforeSend: function() {
                // Show the loading spinner using Swal2
                Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Vui lòng đợi một chút!',
                    didOpen: () => {
                        Swal.showLoading(); // This displays the loading spinner in the Swal modal
                    }
                });
            },
            success: function(response) {
                localStorage.removeItem("checkboxState");

                Swal.fire({
                    icon: 'success',
                    title: 'Khởi tạo thành công!',
                    text: 'Ca làm đã được thêm vào hệ thống.',
                }).then(() => {
                    window.location.href = '/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php';
                });
            },
            error: function(xhr) {
                let errorMessage = 'Có lỗi xảy ra khi thêm ca làm vào hệ thống.';
                if (xhr.error) {
                    errorMessage = xhr.error; // Hiển thị thông báo chi tiết từ server nếu có
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: errorMessage,
                });
            }
        });
    }
</script>
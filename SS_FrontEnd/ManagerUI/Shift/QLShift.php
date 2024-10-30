<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../AdminUI/Admin.css" />
    <link rel="stylesheet" href="../../AdminUI/oneForAll.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Quản lý ca làm</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            max-height: 500px;
            /* Giới hạn chiều cao tối đa */
            overflow-y: auto;
            /* Hiển thị thanh cuộn nếu vượt quá chiều cao tối đa */
            transition: height 0.3s ease;
            /* Hiệu ứng thay đổi chiều cao */
        }


        th,
        td {
            padding: 0.5rem;
            /* Giảm padding để thu gọn kích thước hàng */
            border: 1px solid #ddd;
        }


        .modal,
        .modal1 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal1 {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        #editShiftModal {
            display: flex;
        }

        /* Kiểu nút mũi tên */
        .arrow-button {
            position: relative;
            left: -56%;
            font-weight: bold;
            font-size: 12px;
            padding: 5px 10px;
            background-color: #4CAF50;
            /* Màu nền xanh lá cây */
            color: white;
            /* Màu chữ trắng */
            border: none;
            /* Xóa đường viền */
            border-radius: 5px;
            /* Các góc bo tròn */
            cursor: pointer;
            /* Con trỏ hình bàn tay khi hover */
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Arial', sans-serif;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .arrow-button:hover {
            background-color: #45a049;
            /* Màu khi hover (nhấn chuột vào) */
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
            /* Đổ bóng mạnh hơn khi hover */
        }

        .arrow-button:active {
            transform: scale(0.98);
            /* Hiệu ứng khi nhấn giữ */
        }

        /* Đảm bảo không có khoảng cách không mong muốn xung quanh */
        .input-group {
            display: flex;
            align-items: center;
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
                                            <h2 style="font-size: 7rem; margin: 0; font-family: 'Poppins', sans-serif;">Quản lý ca làm</h2>
                                        </div>
                                        <div class="Admin_boxFeature__ECXnm">
                                            <div style="position: relative;">
                                                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #007bff;"></i>
                                                <input id="searchInput" class="Admin_input__LtEE-" style="font-family: 'Poppins', sans-serif; padding-left: 35px; padding-right: 10px; border-radius: 1rem;" placeholder="Bạn cần tìm kiếm ca làm nào?">
                                            </div>
                                            <select id="shiftFilter" style="height: 3rem; padding: 0.3rem; font-family: 'Poppins', sans-serif; border-radius: 1rem;">
                                                <option value="">Trạng thái: tất cả</option>
                                                <option value="true">Active</option>
                                                <option value="false">InActive</option>
                                            </select>

                                            <button id="addShift" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #7FFF00; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer; width">
                                                <i class="fa-solid fa-plus" style="margin-right: 8px; color: white;"></i>
                                                Thêm ca làm
                                            </button>

                                            <button id="editShift" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #B0C4DE; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                                                <i class="fa-solid fa-edit" style="margin-right: 8px; color: white;"></i>
                                                Sửa
                                            </button>

                                            <button id="detailsShift" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #FFA500; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                                                <i class="fa-solid fa-eye" style="margin-right: 8px; color: white;"></i>
                                                Xem chi tiết
                                            </button>
                                        </div>
                                        <div class="modal1" id="addShiftModal">
                                            <div class="modal-content addShiftForm">
                                                <h3>Thêm Ca Làm</h3>

                                                <div class="input-group">
                                                    <label for="shiftName"><strong>Tên ca làm:</strong></label>
                                                    <input type="text" id="shiftName" required placeholder="Nhập tên ca làm">
                                                </div>

                                                <div class="input-group">
                                                    <label for="startTime"><strong>Thời gian bắt đầu:</strong></label>
                                                    <input type="datetime-local" id="startTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="endTime"><strong>Thời gian kết thúc:</strong></label>
                                                    <input type="datetime-local" id="endTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="breakStartTime"><strong>Bắt đầu thời gian nghỉ:</strong></label>
                                                    <input type="datetime-local" id="breakStartTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="breakEndTime"><strong>Kết thúc thời gian nghỉ:</strong></label>
                                                    <input type="datetime-local" id="breakEndTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="isActive"><strong>Trạng thái ca làm:</strong></label>
                                                    <select id="isActive" required>
                                                        <option value="active">Active</option>
                                                        <option value="inActive">inActive</option>
                                                    </select>
                                                </div>

                                                <div class="input-group">
                                                    <label for="isOT"><strong>Tăng ca:</strong></label>
                                                    <select id="isOT" required>
                                                        <option value="OT">Có</option>
                                                        <option value="nonOT">Không</option>
                                                    </select>
                                                </div>

                                                <div class="input-group">
                                                    <label for="employees">
                                                        <strong>Chọn nhân viên:</strong>
                                                    </label>
                                                    <button id="openAddEmployeeModal" class="arrow-button">>>>></button>
                                                </div>



                                                <input type="hidden" id="shiftStatus" value="true">
                                                <input type="hidden" id="createAt">
                                                <input type="hidden" id="updateAt">

                                                <button id="saveShiftForAdd" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu</button>
                                                <button id="closeAddModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                                            </div>
                                        </div>

                                        <div class="modal" id="addEmployeeModal" style="display: none;">
                                            <div class="modal-content" style="position: relative; left: 940px; top: 220px">
                                                <h3>Chọn nhân viên</h3>
                                                <table id="addEmployeeTable" border="1" style="width: 100%; text-align: left;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Tên nhân viên</th>
                                                            <th>Chọn</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="addEmployeeTableBody">
                                                        <!-- Các hàng của bảng sẽ được thêm động ở đây -->
                                                    </tbody>
                                                </table>
                                                <button id="saveSelectedEmployeesForAdd" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Chọn</button>
                                                <button id="closeAddEmployeeModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                                            </div>
                                        </div>

                                        <!-- Modal Sửa ca làm -->
                                        <div class="modal" id="editShiftModal" style="display: none;"> <!-- Thêm style display: none; để ẩn modal ban đầu -->
                                            <div class="modal-content editShiftForm">
                                                <h3>Sửa ca làm</h3>

                                                <div class="input-group">
                                                    <label for="editShiftName"><strong>Tên ca làm:</strong></label>
                                                    <input type="text" id="editShiftName" required placeholder="Nhập tên ca làm">
                                                </div>

                                                <div class="input-group">
                                                    <label for="editStartTime"><strong>Thời gian bắt đầu:</strong></label>
                                                    <input type="datetime-local" id="editStartTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="editEndTime"><strong>Thời gian kết thúc:</strong></label>
                                                    <input type="datetime-local" id="editEndTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="editBreakStartTime"><strong>Bắt đầu thời gian nghỉ:</strong></label>
                                                    <input type="datetime-local" id="editBreakStartTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="editBreakEndTime"><strong>Kết thúc thời gian nghỉ:</strong></label>
                                                    <input type="datetime-local" id="editBreakEndTime" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="editIsActive"><strong>Trạng thái ca làm:</strong></label>
                                                    <select id="editIsActive" required>
                                                        <option value="active">Active</option>
                                                        <option value="inActive">inActive</option>
                                                    </select>
                                                </div>

                                                <div class="input-group">
                                                    <label for="editIsOT"><strong>Tăng ca:</strong></label>
                                                    <select id="editIsOT" required>
                                                        <option value="OT">Có</option>
                                                        <option value="nonOT">Không</option>
                                                    </select>
                                                </div>

                                                <div class="input-group">
                                                    <label for="employees">
                                                        <strong>Chọn nhân viên:</strong>
                                                    </label>
                                                    <button id="openEditEmployeeModal" class="arrow-button">>>>></button>
                                                </div>

                                                <button id="saveEditShift" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu thay đổi</button>
                                                <button id="closeEditModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                                            </div>
                                        </div>

                                        <div class="modal" id="editEmployeeModal" style="display: none;">
                                            <div class="modal-content" style="position: relative; left: 940px; top: 220px">
                                                <h3>Chọn nhân viên</h3>
                                                <table id="editEmployeeTable" border="1" style="width: 100%; text-align: left;">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Tên nhân viên</th>
                                                            <th>Chọn</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="editEmployeeTableBody">
                                                        <!-- Employee rows will be added here dynamically -->
                                                    </tbody>
                                                </table>
                                                <button id="saveSelectedEmployeesForEdit" style="margin-top: 1rem; background-color: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu</button>
                                                <button id="closeEditEmployeeModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                                            </div>
                                        </div>

                                        <div class="Admin_boxTable__hLXRJ">
                                            <table class="Table_table__BWPy" style="border-radius: 1rem;">
                                                <thead class="Table_head__FTUog">
                                                    <tr>
                                                        <th class="Table_th__hCkcg col-small">Mã ca làm</th>
                                                        <th class="Table_th__hCkcg col-large">Tên ca làm</th>
                                                        <th class="Table_th__hCkcg col-normal">Thời gian bắt đầu</th>
                                                        <th class="Table_th__hCkcg col-normal">Thời gian kết thúc</th>
                                                        <th class="Table_th__hCkcg col-normal">Bắt đầu thời gian nghỉ</th>
                                                        <th class="Table_th__hCkcg col-normal">Kết thúc thời gian nghỉ</th>
                                                        <th class="Table_th__hCkcg col-normal">Tăng ca</th>
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
        var totalPages = 1;
        const token = localStorage.getItem('token');
        var search_state = "";
        var filter_isActive_state = "";


        // Hàm gọi API để lấy dữ liệu và hiển thị trên bảng
        function getAllCaLam(search, status, pageNumber) {
            var searchConverted = removeAccentsAndToLowerCase(search);

            $.ajax({
                url: 'http://localhost:8080/api/Shift/List',
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
                    if (response.status === 200 && response.data) {
                        if (response.data.content.length > 0) {
                            response.data.content.forEach(function(account) {
                                let breakStartTime = account.breakStartTime != null ? account.breakStartTime : "Không có";
                                let breakEndTime = account.breakEndTime != null ? account.breakEndTime : "Không có";

                                var row = `

                            <tr>
                                <td>${account.id}</td>
                                <td>${account.shiftName}</td>
                                <td>${account.startTime}</td>
                                <td>${account.endTime}</td>
                                <td>${breakStartTime}</td>
                                <td>${breakEndTime}</td>
                                <td>${account.isOT === true ? 'Có' : 'Không'}</td>
                                <td>${account.isActive === true ? 'Active' : 'Inactive'}</td>
                            </tr>
                        `;
                                $("#tableBody").append(row);
                            });

                            adjustTableHeight(response.data.content.length);
                        } else {
                            $("#tableBody").append('<tr><td colspan="5">Không có dữ liệu</td></tr>');
                        }

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

        function adjustTableHeight(rowCount) {
            var rowHeight = 50;
            var tableMaxHeight = 400;
            var totalHeight = rowCount * rowHeight;

            if (totalHeight > tableMaxHeight) {
                $('table').css('height', tableMaxHeight + 'px');
            } else {
                $('table').css('height', totalHeight + 'px');
            }
        }

        function renderPagination(currentPage, totalPages) {
            var paginationHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            }

            $('#pagination').html(paginationHTML);
        }

        function changePage(pageNumber) {
            if (pageNumber < 1 || pageNumber > totalPages) {
                return;
            }
            currentPage = pageNumber;
            getAllCaLam($('#searchInput').val(), $('#shiftFilter').val(), currentPage);
        }

        function removeAccentsAndToLowerCase(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }


        getAllCaLam('', '', 1);

        $(document).ready(function() {
            getAllCaLam('', '', currentPage);

            $("#searchInput").on("input", function() {
                var searchValue = $(this).val();
                var statusValue = $("#shiftFilter").val();
                getAllCaLam(searchValue, statusValue, currentPage);
            });

            $("#shiftFilter").on("change", function() {
                var searchValue = $("#searchInput").val();
                var statusValue = $(this).val();
                getAllCaLam(searchValue, statusValue, currentPage);
            });

            $("#detailsNV").click(function() {
                const selectedRow = $("tr.selected");
                if (selectedRow.length === 0) {
                    Swal.fire('Chưa chọn ca làm!', 'Vui lòng chọn một ca làm để xem chi tiết.', 'warning');
                } else {
                    const shiftCode = selectedRow.find("td").eq(0).text();
                    getEmployeeDetails(shiftCode);
                }
            });

            $("#closeModal").click(function() {
                $("#detailsModal").hide();
            });

            $(document).on('click', 'tr', function() {
                $('tr').removeClass('selected');
                $(this).addClass('selected');
            });



            $("#addShift").click(function() {
                $("#shiftName").val('');
                $("#startTime").val('');
                $("#endTime").val('');
                $("#breakStartTime").val('');
                $("#breakEndTime").val('');
                $("#isActive").val('active');
                $("#isOT").val('OT');
                $("#addShiftModal").show();
            });

            function loadEmployeesForAddShift(search, status, pageNumber) {
                $.ajax({
                    url: 'http://localhost:8080/api/Profile/List',
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: search,
                        status: status,
                        pageNumber: pageNumber,
                        pageSize: 1
                    },
                    headers: {
                        'Authorization': 'Bearer ' + token // Thay bằng token của bạn
                    },
                    success: function(response) {
                        if (response && response.data.content) {
                            const addEmployeeTableBody = $(".addEmployeeTableBody");
                            addEmployeeTableBody.empty(); // Xóa hàng cũ trong bảng

                            response.data.content.forEach(employee => {
                                const row = $('<tr></tr>'); // Tạo hàng mới cho bảng

                                // Tạo cột ID
                                const idCell = $('<td></td>').text(employee.code);
                                row.append(idCell);

                                // Tạo cột tên nhân viên
                                const nameCell = $('<td></td>').text(employee.fullname);
                                row.append(nameCell);

                                // Tạo cột checkbox
                                const checkboxCell = $('<td></td>');
                                const checkbox = $('<input>')
                                    .attr('type', 'checkbox')
                                    .attr('id', 'employee_' + employee.code)
                                    .attr('value', employee.code);
                                checkboxCell.append(checkbox);
                                row.append(checkboxCell);

                                addEmployeeTableBody.append(row); // Thêm hàng vào bảng
                            });
                        } else {
                            Swal.fire('Lỗi', 'Không thể tải danh sách nhân viên.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Có lỗi xảy ra khi tải danh sách nhân viên.', 'error');
                    }
                });
            }

            $("#closeAddModal").click(function() {
                $("#addShiftModal").hide();
            });

            $("#closeAddEmployeeModal").click(function() {
                $("#addEmployeeModal").hide();
                $(".addShiftForm").css({
                    "right": "0px"
                });
            });

            $("#openAddEmployeeModal").click(function() {
                loadEmployeesForAddShift('', '', 1);
                $("#addEmployeeModal").show();
                $(".addShiftForm").css({
                    "position": "relative",
                    "right": "200px"
                });
            });

            $("#saveSelectedEmployeesForAdd").click(function() {
                const selectedEmployees = [];
                $(".addEmployeeTableBody input[type='checkbox']:checked").each(function() {
                    selectedEmployees.push($(this).val()); // Lấy mã nhân viên đã chọn
                });
                console.log(selectedEmployees);
                // Đóng modal và chỉnh lại CSS
                $(".addShiftForm").css({
                    "right": "0px"
                });
                $("#addEmployeeModal").hide();
            });

            $("#saveShiftForAdd").click(function() {
                // Hàm định dạng thời gian thành yyyy-MM-dd'T'HH:mm:ss
                function formatDateTime(date) {
                    const year = date.getFullYear();
                    const month = ('0' + (date.getMonth() + 1)).slice(-2);
                    const day = ('0' + date.getDate()).slice(-2);
                    const hours = ('0' + date.getHours()).slice(-2);
                    const minutes = ('0' + date.getMinutes()).slice(-2);
                    const seconds = ('0' + date.getSeconds()).slice(-2);
                    return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
                }
                const shiftName = $("#shiftName").val().trim();
                const startTime = formatDateTime(new Date($("#startTime").val()));
                const endTime = formatDateTime(new Date($("#endTime").val()));
                const breakStartTime = formatDateTime(new Date($("#breakStartTime").val()));
                const breakEndTime = formatDateTime(new Date($("#breakEndTime").val()));

                const isActive = $("#isActive").val();
                const isOT = $("#isOT").val();

                // Thu thập danh sách nhân viên đã chọn từ modal
                const selectedEmployees = [];
                $(".addEmployeeTableBody input[type='checkbox']:checked").each(function() {
                    selectedEmployees.push($(this).val()); // Lấy giá trị của checkbox
                });

                if (!shiftName) {
                    Swal.fire('Lỗi', 'Vui lòng nhập tên ca làm.', 'error');
                    return;
                }

                if (!startTime) {
                    Swal.fire('Lỗi', 'Vui lòng chọn thời gian bắt đầu.', 'error');
                    return;
                }

                if (!endTime) {
                    Swal.fire('Lỗi', 'Vui lòng chọn thời gian kết thúc.', 'error');
                    return;
                }

                if (!breakStartTime) {
                    Swal.fire('Lỗi', 'Vui lòng chọn thời gian bắt đầu nghỉ.', 'error');
                    return;
                }

                if (!breakEndTime) {
                    Swal.fire('Lỗi', 'Vui lòng chọn thời gian kết thúc nghỉ.', 'error');
                    return;
                }

                if (!isActive) {
                    Swal.fire('Lỗi', 'Vui lòng chọn trạng thái ca làm.', 'error');
                    return;
                }

                if (!isOT) {
                    Swal.fire('Lỗi', 'Vui lòng chọn tăng ca.', 'error');
                    return;
                }

                // Kiểm tra xem thời gian bắt đầu có sớm hơn thời gian kết thúc không
                if (new Date(startTime) >= new Date(endTime)) {
                    Swal.fire('Lỗi', 'Thời gian bắt đầu phải sớm hơn thời gian kết thúc.', 'error');
                    return;
                }

                // Kiểm tra xem thời gian bắt đầu nghỉ có sớm hơn thời gian kết thúc nghỉ không
                if (new Date(breakStartTime) >= new Date(breakEndTime)) {
                    Swal.fire('Lỗi', 'Thời gian bắt đầu nghỉ phải sớm hơn thời gian kết thúc nghỉ.', 'error');
                    return;
                }

                // Tạo dữ liệu form
                const formData = new FormData();
                formData.append('shiftName', shiftName);
                formData.append('startTime', startTime);
                formData.append('endTime', endTime);
                formData.append('breakStartTime', breakStartTime);
                formData.append('breakEndTime', breakEndTime);
                formData.append('isActive', isActive === 'active');
                formData.append('isOT', isOT === 'OT');
                formData.append('status', true);
                formData.append('createAt', new Date().toISOString());
                formData.append('updateAt', new Date().toISOString());

                // Thêm danh sách nhân viên đã chọn vào formData
                selectedEmployees.forEach(function(employeeCode, index) {
                    formData.append(`profileCodes[${index}]`, employeeCode);
                });

                // Gửi yêu cầu Ajax
                $.ajax({
                    url: 'http://localhost:8080/api/Shift/Create', // Đường dẫn API của bạn
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        if (response.status === 201) {
                            Swal.fire('Thành công', 'Thêm ca làm thành công!', 'success');
                            $("#addShiftModal").hide();
                            // Cập nhật danh sách ca làm nếu cần
                        } else {
                            Swal.fire('Lỗi', 'Thêm ca làm thất bại.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error("Lỗi khi gọi API thêm ca làm", xhr.responseJSON);
                        Swal.fire('Lỗi', 'Có lỗi xảy ra khi thêm ca làm.', 'error');
                    }
                });
                getAllCaLam('', '', 1);
            });



            $("#editShift").click(function() {
                const selectedRow = $("tr.selected");
                if (selectedRow.length === 0) {
                    Swal.fire('Chưa chọn ca làm!', 'Vui lòng chọn một ca làm để sửa.', 'warning');
                } else {
                    const shiftCode = selectedRow.find("td").first().text().trim();
                    openEditModal(shiftCode);
                }
            });

            function loadEmployeesForEditShift(search, status, pageNumber, selectedEmployees = []) {
                $.ajax({
                    url: 'http://localhost:8080/api/Profile/List',
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: search,
                        status: status,
                        pageNumber: pageNumber,
                        pageSize: pageSize
                    },
                    headers: {
                        'Authorization': 'Bearer ' + token // Replace with your actual token
                    },
                    success: function(response) {
                        if (response && response.data.content) {
                            const editEmployeeTableBody = $(".editEmployeeTableBody");
                            editEmployeeTableBody.empty(); // Clear the existing rows in the table

                            response.data.content.forEach(employee => {
                                const row = $('<tr></tr>'); // Create a new row for each employee

                                // Add ID column
                                const idCell = $('<td></td>').text(employee.code);
                                row.append(idCell);

                                // Add Name column
                                const nameCell = $('<td></td>').text(employee.fullname);
                                row.append(nameCell);

                                // Add Checkbox column
                                const checkboxCell = $('<td></td>');
                                const checkbox = $('<input>')
                                    .attr('type', 'checkbox')
                                    .attr('id', 'employee_' + employee.code)
                                    .attr('value', employee.code)
                                    .prop('checked', selectedEmployees.includes(employee.code)); // Mark checked if in selectedEmployees
                                checkboxCell.append(checkbox);
                                row.append(checkboxCell);

                                editEmployeeTableBody.append(row); // Append the row to the table
                            });
                        } else {
                            Swal.fire('Lỗi', 'Không thể tải danh sách nhân viên.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Có lỗi xảy ra khi tải danh sách nhân viên.', 'error');
                    }
                });
            }

            // Function to delete all employees from a shift
            function deleteAllEmployeesFromShift(shiftId) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `http://localhost:8080/api/Shift/Detail?id=${shiftId}`,
                        type: 'GET',
                        dataType: "json",
                        headers: {
                            'Authorization': 'Bearer ' + token // Replace with your token
                        },
                        success: function(response) {
                            if (response.status === 200 && response.data) {
                                const employees = response.data.signUps.map(signUp => signUp.profile.code);
                                const deletePromises = employees.map(profileCode => {
                                    const formData = new FormData();
                                    formData.append('shiftId', shiftId);
                                    formData.append('profileCode', profileCode);

                                    return $.ajax({
                                        url: `http://localhost:8080/api/ShiftSignUp/Delete`,
                                        type: 'DELETE',
                                        processData: false,
                                        contentType: false,
                                        data: formData,
                                        headers: {
                                            'Authorization': 'Bearer ' + token
                                        }
                                    });
                                });

                                // Wait for all delete requests to complete
                                Promise.all(deletePromises)
                                    .then(() => resolve())
                                    .catch(() => reject("Failed to delete one or more employees from shift."));
                            } else {
                                reject("Failed to fetch shift details or no employees found.");
                            }
                        },
                        error: function() {
                            reject("Error fetching shift details.");
                        }
                    });
                });
            }

            function addEmployeesToShift(shiftId, profileCodes) {
                const addPromises = profileCodes.map(profileCode => {
                    const formData = new FormData();
                    formData.append('shiftId', shiftId);
                    formData.append('profileCodes', profileCode);

                    return $.ajax({
                        url: `http://localhost:8080/api/ShiftSignUp/Create`,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        headers: {
                            'Authorization': 'Bearer ' + token // Replace with your token
                        }
                    });
                });

                // Wait for all add requests to complete
                return Promise.all(addPromises);
            }



            function openEditModal(shiftCode) {
                $.ajax({
                    url: `http://localhost:8080/api/Shift/Detail?id=${shiftCode}`,
                    type: 'GET',
                    dataType: "json",
                    headers: {
                        'Authorization': 'Bearer ' + token // Replace with your token
                    },
                    success: function(response) {
                        if (response.status === 200 && response.data) {
                            const data = response.data;
                            const selectedEmployees = data.signUps.map(signUp => signUp.profile.code);

                            function formatDateTime(dateString) {
                                const [time, date] = dateString.split(" ");
                                const [day, month, year] = date.split("/");
                                return `${year}-${month}-${day}T${time.slice(0, 5)}`;
                            }

                            $("#editShiftId").val(data.id);
                            $("#editShiftName").val(data.shiftName);
                            $("#editStartTime").val(formatDateTime(data.startTime));
                            $("#editEndTime").val(formatDateTime(data.endTime));
                            $("#editBreakStartTime").val(formatDateTime(data.breakStartTime));
                            $("#editBreakEndTime").val(formatDateTime(data.breakEndTime));
                            $("#editIsActive").val(data.isActive ? 'active' : 'inActive');
                            $("#editIsOT").val(data.isOT ? 'OT' : 'nonOT');
                            $("#editShiftModal").show();

                            loadEmployeesForEditShift('', '', 1, selectedEmployees);
                        } else {
                            Swal.fire('Lỗi', 'Không tìm thấy thông tin chi tiết.', 'error');
                        }
                    },
                    error: function() {
                        console.error("Lỗi khi gọi API chi tiết ca làm");
                        Swal.fire('Lỗi', 'Không thể lấy thông tin chi tiết.', 'error');
                    }
                });

                $("#saveEditShift").on('click', function() {
                    function formatDateTime(date) {
                        const year = date.getFullYear();
                        const month = ('0' + (date.getMonth() + 1)).slice(-2);
                        const day = ('0' + date.getDate()).slice(-2);
                        const hours = ('0' + date.getHours()).slice(-2);
                        const minutes = ('0' + date.getMinutes()).slice(-2);
                        const seconds = ('0' + date.getSeconds()).slice(-2);
                        return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
                    }

                    const formData = new FormData();
                    const startTime = new Date($("#editStartTime").val());
                    const endTime = new Date($("#editEndTime").val());
                    const breakStartTime = new Date($("#editBreakStartTime").val());
                    const breakEndTime = new Date($("#editBreakEndTime").val());
                    const isActive = $("#editIsActive").val();
                    const isOT = $("#editIsOT").val();

                    formData.append('id', shiftCode);
                    formData.append('shiftName', $("#editShiftName").val().trim());
                    formData.append('isActive', isActive === 'active');
                    formData.append('isOT', isOT === 'OT');
                    formData.append('startTime', formatDateTime(startTime));
                    formData.append('endTime', formatDateTime(endTime));
                    formData.append('breakStartTime', formatDateTime(breakStartTime));
                    formData.append('breakEndTime', formatDateTime(breakEndTime));

                    $.ajax({
                        url: `http://localhost:8080/api/Shift/Update`,
                        type: 'PATCH',
                        processData: false,
                        contentType: false,
                        data: formData,
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire('Thành công', 'Cập nhật thông tin ca làm thành công!', 'success');
                                $("#editShiftModal").hide();
                            } else {
                                Swal.fire('Lỗi', 'Không thể cập nhật thông tin ca làm.', 'error');
                            }
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.error ?
                                Object.values(xhr.responseJSON.error).join(", ") :
                                'Không thể cập nhật thông tin ca làm.';
                            Swal.fire('Lỗi', errorMsg, 'error');
                        }
                    });

                    // Xóa tất cả nhân viên trong ca trước khi thêm lại
                    deleteAllEmployeesFromShift(shiftCode)
                        .then(() => {
                            const selectedEmployees = [];
                            $(".editEmployeeTableBody input[type='checkbox']:checked").each(function() {
                                selectedEmployees.push($(this).val());
                            });
                            return addEmployeesToShift(shiftCode, selectedEmployees);
                        })
                        .then(() => {
                            console.log("All employees added to shift successfully.");
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire('Lỗi', 'Có lỗi khi xóa hoặc thêm nhân viên.', 'error');
                        });
                    getAllCaLam('', '', 1);
                });
            }


            $("#closeEditModal").on('click', function() {
                $("#editShiftModal").hide();
            });
        });

        $("#openEditEmployeeModal").click(function() {
            $("#editEmployeeModal").show();
            $(".editShiftForm").css({
                "position": "relative",
                "right": "200px"
            });
        });

        $("#closeEditEmployeeModal").click(function() {
            $("#editEmployeeModal").hide();
            $(".editShiftForm").css({
                "right": "0px"
            });
        });

        $("#saveSelectedEmployeesForEdit").click(function() {
            const selectedEmployees = [];
            $(".editEmployeeTableBody input[type='checkbox']:checked").each(function() {
                selectedEmployees.push($(this).val()); // Lấy mã nhân viên đã chọn
            });
            $(".editShiftForm").css({
                "right": "0px"
            });
            $("#editEmployeeModal").hide();
        });



        function getEmployeeDetails(shiftCode) {
            $.ajax({
                url: `http://localhost:8080/api/Profile/Detail?code=${shiftCode}`,
                type: 'GET',
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token
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
    </script>

</body>

</html>
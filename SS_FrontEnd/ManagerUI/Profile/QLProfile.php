<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../AdminUI/Account.css" />
    <link rel="stylesheet" href="./QLProfile.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Quản lý nhân viên</title>

</head>
<body>
    <?php include_once '../../Header.php'; ?>
    <div class="StaffLayout_wrapper__CegPk">
        <div style="padding-left: 4%; width: 100%; padding-right: 5%">
            <div class="wrapper">
                <div style="
                    display: flex;
                    padding-top: 1rem;
                    padding-bottom: 1rem;
                    justify-content: center; 
                    align-items: center;
                    text-align: center;
                ">
                    <h2 style="font-size: 4rem; margin: 0; font-family: 'Poppins', sans-serif;">Quản lý nhân sự</h2>
                </div>
                <div class="Admin_boxFeature__ECXnm">
                    <div style="position: relative; width: 50%;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #007bff;"></i>
                        <input id="searchInput" class="Admin_input__LtEE-" style="width: 100%; font-family: 'Poppins', sans-serif; padding-left: 35px; padding-right: 10px; border-radius: 1rem;" placeholder="Bạn cần tìm kiếm nhân viên nào?">
                    </div>
                    
                    <select id="selectQuyen" style="height: 3rem; padding: 0.3rem; font-family: 'Poppins', sans-serif; border-radius: 1rem;">
                        <option value="">Trạng thái: tất cả</option>
                        <option value="true">Active</option>
                        <option value="false">InActive</option>
                    </select>

                    <button id="addNV" style="height: 100%; font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #7FFF00; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer; width">
                        <i class="fa-solid fa-plus" style="margin-right: 5px; color: white;"></i>
                        Thêm nhân viên
                    </button>

                    <button id="editNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #B0C4DE; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                        <i class="fa-solid fa-edit" style="margin-right: 8px; color: white;"></i>
                        Sửa
                    </button>

                    <button id="detailsNV" style="font-family: 'Poppins', sans-serif; display: flex; align-items: center; background-color: #FFA500; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">
                        <i class="fa-solid fa-eye" style="margin-right: 8px; color: white;"></i>
                        Xem chi tiết
                    </button>
                </div>
                
                <div class="modal1" id="addEmployeeModal">
                    <div class="modal-content">
                        <h3>Thêm Nhân Viên</h3>

                        <div class="input-group">
                            <label for="employeeName"><strong>Tên nhân viên:</strong></label>
                            <input type="text" id="employeeName" required placeholder="Nhập tên nhân viên">
                        </div>

                        <div class="input-group">
                            <label for="employeeGender"><strong>Giới tính:</strong></label>
                            <select id="employeeGender" required>
                                <option value="Male">Nam</option>
                                <option value="Female">Nữ</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="employeeBirthday"><strong>Ngày sinh:</strong></label>
                            <input type="date" id="employeeBirthday" required>
                        </div>

                        <div class="input-group">
                            <label for="employeePhone"><strong>Số điện thoại:</strong></label>
                            <input type="text" id="employeePhone" required placeholder="Nhập số điện thoại">
                        </div>

                        <div class="input-group">   
                            <label for="employeeEmail"><strong>Email:</strong></label>
                            <input type="email" id="employeeEmail" required placeholder="Nhập email">
                        </div>

                        <div class="input-group">
                            <label for="employeePosition"><strong>Vị trí:</strong></label>
                            <select id="employeePosition" required>
                                <option value="Employee">Nhân viên</option>
                                <option value="Manager">Quản lý</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="employeeImages"><strong>Ảnh vân tay:</strong></label>
                            <input type="file" id="employeeImages" multiple accept="image/*">   
                        </div>

                        <input type="hidden" id="employeeStatus" value="true">
                        <input type="hidden" id="createAt">
                        <input type="hidden" id="updateAt">

                        <button id="saveEmployee" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu</button>
                        <button id="closeAddModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
                    </div>
                </div>


                <!-- Modal Sửa Nhân Viên -->
                <div class="modal" id="editEmployeeModal" style="display: none;"> <!-- Thêm style display: none; để ẩn modal ban đầu -->
                    <div class="modal-content">
                        <h3>Sửa Nhân Viên</h3>

                        <div class="input-group">
                            <label for="editEmployeeName"><strong>Tên nhân viên:</strong></label>
                            <input type="text" id="editEmployeeName" required placeholder="Nhập tên nhân viên">
                        </div>

                        <div class="input-group">
                            <label for="editEmployeeGender"><strong>Giới tính:</strong></label>
                            <select id="editEmployeeGender" required>
                                <option value="Male">Nam</option>
                                <option value="Female">Nữ</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="editEmployeeBirthday"><strong>Ngày sinh:</strong></label>
                            <input type="date" id="editEmployeeBirthday" required>
                        </div>

                        <div class="input-group">
                            <label for="editEmployeePhone"><strong>Số điện thoại:</strong></label>
                            <input type="text" id="editEmployeePhone" required placeholder="Nhập số điện thoại">
                        </div>

                        <div class="input-group">
                            <label for="editEmployeeEmail"><strong>Email:</strong></label>
                            <input type="email" id="editEmployeeEmail" required placeholder="Nhập email">
                        </div>

                        <button id="saveEditEmployee" style="margin-top: 1rem; background-color: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Lưu thay đổi</button>
                        <button id="closeEditModal" style="margin-top: 1rem; background-color: #ff4d4d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 1rem; cursor: pointer;">Đóng</button>
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


    <script>
        var currentPage = 1;
        var pageSize = 5;
        var totalPages = 1;
        const token = localStorage.getItem('token');
// Hàm gọi API để lấy dữ liệu và hiển thị trên bảng
function getAllTaiKhoan(search, status, pageNumber) {
    var searchConverted = removeAccentsAndToLowerCase(search);
    const token = localStorage.getItem('token');
    $.ajax({
        url: 'http://localhost:8080/api/Profile/List',
        type: 'GET',
        dataType: "json",
        data: {
            search: searchConverted,
            status: status,
            pageNumber: pageNumber,
            size: pageSize
        },
        headers: {
            'Authorization': 'Bearer ' + token
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
    getAllTaiKhoan($('#searchInput').val(), $('#selectQuyen').val(), currentPage);
}

function removeAccentsAndToLowerCase(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
}


getAllTaiKhoan('', '', 1); 

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
    $("#employeeCode").val('');
    $("#employeeName").val('');
    $("#employeeGender").val('Male'); 
    $("#employeeBirthday").val(''); 
    $("#employeePhone").val('');
    $("#employeeEmail").val('');
    $("#employeePosition").val('Employee'); 
    $("#addEmployeeModal").show();
});

$("#closeAddModal").click(function() {
    $("#addEmployeeModal").hide();
});



$("#closeAddModal").click(function () {
    $("#addEmployeeModal").hide(); 
});


$("#closeAddModal").click(function() {
    $("#addEmployeeModal").hide();
});

$("#saveEmployee").click(function() {
    const fullname = $("#employeeName").val().trim();
    const gender = $("#employeeGender").val();
    const birthday = $("#employeeBirthday").val(); 
    const phone = $("#employeePhone").val().trim();
    const email = $("#employeeEmail").val().trim();
    const position = $("#employeePosition").val(); // Vị trí

    if (!fullname || !gender || !birthday || !phone || !email || !position) {
        Swal.fire('Lỗi', 'Vui lòng điền tất cả các trường bắt buộc.', 'error');
        return; 
    }

    if (!/^\d{10}$/.test(phone)) {
        Swal.fire('Lỗi', 'Số điện thoại phải có đúng 10 chữ số.', 'error');
        return; 
    }

    const formData = new FormData();
    formData.append('fullname', fullname);
    formData.append('gender', gender);
    formData.append('birthday', birthday);
    formData.append('phone', phone);
    formData.append('email', email);
    formData.append('position', position);
    formData.append('status', true);
    formData.append('createAt', new Date().toISOString().split('T')[0] + " 08:00:00");
    formData.append('updateAt', new Date().toISOString().split('T')[0] + " 08:00:00");


    const imagesInput = document.getElementById('employeeImages'); 
    const images = imagesInput.files; 

    if (images.length > 0) {
        for (let i = 0; i < images.length; i++) {
            formData.append('images', images[i]); 
        }
    } else {
        Swal.fire('Lỗi', 'Vui lòng chọn ít nhất một ảnh.', 'error');
        return;
    }

    $.ajax({
        url: 'http://localhost:8080/api/Profile/Create',
        type: 'POST',
        processData: false, 
        contentType: false, 
        data: formData,
        headers: {
            'Authorization': 'Bearer ' + token // Thay YOUR_JWT_TOKEN bằng token thật của bạn
        },
        success: function(response) {
            if (response.status === 200) {
                Swal.fire('Thành công', 'Thêm nhân viên thành công!', 'success');
                $("#addEmployeeModal").hide();
                getAllTaiKhoan('', '', currentPage); 
            } else {
                Swal.fire('Thành công', 'Thêm nhân viên thành công!', 'success');
            }
        },
        error: function(xhr) {
            console.error("Lỗi khi gọi API thêm nhân viên", xhr.responseJSON);
            if (xhr.responseJSON && xhr.responseJSON.error) {
                Swal.fire('Lỗi', xhr.responseJSON.error, 'error');
            } else {
                Swal.fire('Lỗi', 'Có lỗi xảy ra khi thêm nhân viên.', 'error');
            }
        }
    });
});


$("#editNV").click(function() {
    const selectedRow = $("tr.selected"); 
    if (selectedRow.length === 0) {
        Swal.fire('Chưa chọn nhân viên!', 'Vui lòng chọn một nhân viên để sửa.', 'warning');
    } else {
        const employeeCode = selectedRow.find("td").first().text().trim(); 
        openEditModal(employeeCode); 
    }
});

$("#saveEditEmployee").on('click', function() {
    const selectedRow = $("tr.selected"); 
    if (selectedRow.length === 0) {
        Swal.fire('Chưa chọn nhân viên!', 'Vui lòng chọn một nhân viên để sửa.', 'warning');
        return; 
    }

    if (!/^\d{10}$/.test($("#editEmployeePhone").val().trim())) {
        Swal.fire('Lỗi', 'Số điện thoại phải có đúng 10 chữ số.', 'error');
        return; 
    }
    
    const employeeCode = selectedRow.find("td").first().text().trim(); 
    const formData = new FormData(); 

    formData.append('profileCode', employeeCode);
    formData.append('fullname', $("#editEmployeeName").val().trim());
    formData.append('gender', $("#editEmployeeGender").val());
    formData.append('birthday', $("#editEmployeeBirthday").val());
    formData.append('phone', $("#editEmployeePhone").val().trim());
    formData.append('email', $("#editEmployeeEmail").val().trim());
    formData.append('status', $("#status").is(":checked")); 


    $.ajax({
        url: `http://localhost:8080/api/Profile/Update`, 
        type: 'PATCH',
        processData: false, 
        contentType: false, 
        data: formData,
        headers: {
            'Authorization': 'Bearer ' + token // Thay thế bằng token của bạn
        },
        success: function(response) {
            if (response.status === 200) {
                Swal.fire('Thành công', 'Cập nhật thông tin nhân viên thành công!', 'success');
                $("#editEmployeeModal").hide(); 
                refreshEmployeeList(); 
            } else {
                Swal.fire('Lỗi', 'Không thể cập nhật thông tin nhân viên.', 'error');
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.error) {
                const errors = Object.values(xhr.responseJSON.error).join(", ");
                Swal.fire('Lỗi', `Có lỗi trong quá trình cập nhật: ${errors}`, 'error');
            } else {
                Swal.fire('Lỗi', 'Không thể cập nhật thông tin nhân viên.', 'error');
            }
        }
    });
});


function openEditModal(employeeCode) {
    $.ajax({
        url: `http://localhost:8080/api/Profile/Detail?code=${employeeCode}`,
        type: 'GET',
        dataType: "json",
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(response) {
            if (response.status === 200 && response.data) {
                $("#editEmployeeId").val(response.data.id); 
                $("#editEmployeeName").val(response.data.fullname);
                $("#editEmployeeGender").val(response.data.gender);
                $("#editEmployeeBirthday").val(response.data.birthday);
                $("#editEmployeePhone").val(response.data.phone);
                $("#editEmployeeEmail").val(response.data.email);
                $("#editEmployeeModal").show();
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

// Đóng modal
$("#closeEditModal").on('click', function() {
    $("#editEmployeeModal").hide();
});
});

function getEmployeeDetails(employeeCode) {
            $.ajax({
                url: `http://localhost:8080/api/Profile/Detail?code=${employeeCode}`,
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
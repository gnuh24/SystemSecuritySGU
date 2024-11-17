<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">
    <title>Cập nhật nhân sự</title>

</head>
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

    <script>
      
        function removeAccentsAndToLowerCase(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        $(document).ready(function() {

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
                    Swal.fire('Thành công', 'Thêm nhân viên thành công!', 'success');
                    $("#addEmployeeModal").hide();
                    getAllTaiKhoan('', '', currentPage); 
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
            Swal.fire('Thành công', 'Cập nhật thông tin nhân viên thành công!', 'success');
            $("#editEmployeeModal").hide(); 
            refreshEmployeeList(); 
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
            $("#editEmployeeId").val(response.data.id); 
            $("#editEmployeeName").val(response.data.fullname);
            $("#editEmployeeGender").val(response.data.gender);
            $("#editEmployeeBirthday").val(response.data.birthday);
            $("#editEmployeePhone").val(response.data.phone);
            $("#editEmployeeEmail").val(response.data.email);
            $("#editEmployeeModal").show();
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
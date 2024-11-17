<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">

    <title>Chi tiết nhân sự</title>

</head>
<style>
    input {
        text-indent: 15px; 
        height: 35px;
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
                id="profileCodeBreadcrumb" 
                >
                Hello
                </a>
            </div>
            </li>

        </ol>
    </nav>

    <div class="m-20 my-8 p-12 py-8 bg-white rounded-lg shadow-lg">
        <form>
            <h2 class="text-base/7 font-semibold text-gray-900">Thông tin nhân viên</h2>

            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="profileCode" class="block text-sm/6 font-medium text-gray-900">Mã nhân viên</label>
                    <div class="mt-2">
                        <input type="text" name="profileCode" id="profileCode" autocomplete="given-name" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="fullname" class="block text-sm/6 font-medium text-gray-900">Tên nhân viên</label>
                    <div class="mt-2">
                        <input type="text" name="fullname" id="fullname" autocomplete="family-name" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Địa chỉ email</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="phone" class="block text-sm/6 font-medium text-gray-900">Số điện thoại</label>
                    <div class="mt-2">
                        <input type="text" name="phone" id="phone" autocomplete="tel" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm/6 font-medium text-gray-900">Trạng thái</label>
                    <div class="mt-2">
                        <input type="text" name="status" id="status" autocomplete="tel" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="gender" class="block text-sm/6 font-medium text-gray-900">Giới tính</label>
                    <div class="mt-2">
                        <input type="text" name="gender" id="gender" autocomplete="gender" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="birthday" class="block text-sm/6 font-medium text-gray-900">Ngày sinh</label>
                    <div class="mt-2">
                        <input type="text" name="birthday" id="birthday" autocomplete="birthday" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="createAt" class="block text-sm/6 font-medium text-gray-900">Thời gian tạo profile</label>
                    <div class="mt-2">
                        <input type="text" name="createAt" id="createAt" autocomplete="createAt" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="updateAt" class="block text-sm/6 font-medium text-gray-900">Lần cập nhật gần nhất</label>
                    <div class="mt-2">
                        <input type="text" name="updateAt" id="updateAt" autocomplete="updateAt" disabled class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="button" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md">
                    Quay lại
                </button>
            </div>
        </form>
    </div>



<script>
    var employeeCode = '<?php echo $_GET['code'] ?>';
    const token = localStorage.getItem('token');

    $(document).ready(function() {
        getEmployeeDetails(employeeCode);
        
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
                    // Populate the form fields with the response data
                    $('#profileCode').val(response.data.code);
                    $('#profileCodeBreadcrumb').text(response.data.code);

                    $('#fullname').val(response.data.fullname);
                    $('#email').val(response.data.email);
                    $('#phone').val(response.data.phone);
                    
                    // Gender handling
                    let genderValue = response.data.gender;

                    // Map the API value to the correct value in the select options
                    if (genderValue === 'Male') {
                        $('#gender').val('Nam');
                    } else if (genderValue === 'Female') {
                        $('#gender').val('Nữ');
                    } else {
                        $('#gender').val('Khác');
                    }
                    
                    $('#birthday').val(response.data.birthday);
                    $('#createAt').val(response.data.createAt);
                    $('#updateAt').val(response.data.updateAt);

                    // Status (Assuming status is a boolean, if true you can set a value)
                    // You can customize this based on how you want to show the status field
                    $('#status').val(response.data.status ? 'Active' : 'Inactive');  // Adjust this if your form has a specific way to handle status.
                }
            },
            error: function() {
                Swal.fire('Lỗi', 'Không thể lấy thông tin chi tiết.', 'error')
                .then(() => {
                    window.location.href = '/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';
                });
            }
        });
    }

</script>
        
</body>

</html>
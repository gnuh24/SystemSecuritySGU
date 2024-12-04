<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">
    <title>Thêm nhân sự</title>

</head>
<style>
    input, select, option   {
        text-indent: 15px; 
        height: 35px;
        border: 1px solid black;

    }
    button {
        background: linear-gradient(135deg, #67a5e5, #9b59b6) !important;
    }
    .bg-red-500{
        background-color: red !important;
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
                Thêm nhân viên mới
                </a>
            </div>
            </li>

        </ol>
    </nav>

    <div class="m-20 my-8 p-12 py-8 bg-white rounded-lg shadow-lg">
        <form>
            <h2 class="text-base/7 font-semibold text-gray-900">Thông tin nhân viên</h2>

            <div class="border-b border-gray-900/10 pb-12 mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <label for="fullname" class="block text-sm/6 font-medium text-gray-900">Tên nhân viên</label>
                    <div class="mt-2">
                        <input type="text" name="fullname" id="fullname" autocomplete="family-name" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="phone" class="block text-sm/6 font-medium text-gray-900">Số điện thoại</label>
                    <div class="mt-2">
                        <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Địa chỉ email</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                

                <div class="sm:col-span-2">
                    <label for="gender" class="block text-sm/6 font-medium text-gray-900">Giới tính</label>
                    <div class="mt-2">
                        <select name="gender" id="gender" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Other">Khác</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="position" class="block text-sm/6 font-medium text-gray-900">Vị trí</label>
                    <div class="mt-2">
                        <select name="position" id="position" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            <option value="Employee">Nhân viên</option>
                            <option value="Manager">Quản lý</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="birthday" class="block text-sm/6 font-medium text-gray-900">Ngày sinh</label>
                    <div class="mt-2">
                        <input type="date" name="birthday" id="birthday" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Xác thực sinh trắc học</label>
                    <div id="drop-zone" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10" 
                        ondragover="handleDragOver(event)" 
                        ondragleave="handleDragLeave(event)" 
                        ondrop="handleFileDrop(event)">
                        <div id="preview-container" class="text-center">
                            <svg style="max-width: 300px;" class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm/6 text-gray-600 text-center flex items-center justify-center">
                                <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                    <span>Tải ảnh vân tay</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple onchange="handleFileSelect(event)">
                                </label>
                                <p class="pl-1">hoặc kéo và thả</p>
                            </div>
                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF tối đa 10MB</p>
                            <div id="imagesZone" class="flex">

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 flex justify-around">
                <button type="button" class="w-2/5 text-white py-2 px-4 rounded-md" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';">
                    Quay lại
                </button>
                <button type="button" class="w-2/5 text-white py-2 px-4 rounded-md" id="createButton">
                    Tạo profile
                </button>
            </div>
        </form>
    </div>

<script>
    const token = localStorage.getItem('token');

    $(document).ready(function() {
        document.getElementById("createButton").addEventListener("click", function() {
            if (validCreateForm()) {
                callAPICreate();
            }
        });

    });

    var images = [];


    function handleDragOver(event) { 
        event.preventDefault();
        event.currentTarget.classList.add('bg-gray-200');
    }

    function handleDragLeave(event) {
        event.currentTarget.classList.remove('bg-gray-200');
    }

    function handleFileDrop(event) {
        event.preventDefault();
        event.currentTarget.classList.remove('bg-gray-200');
        const files = event.dataTransfer.files;
        validateFiles(files);
    }

    function handleFileSelect(event) {
        const files = event.target.files;
        validateFiles(files);
    }

    function validateFiles(files) {
        const allowedExtensions = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 10 * 1024 * 1024; // 10 MB
        const previewContainer = document.getElementById('imagesZone');

        for (const file of files) {
            // Check for valid file type
            if (!allowedExtensions.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tệp không hợp lệ. Chỉ chấp nhận PNG, JPG, và GIF.',
                });
                continue; // Skip invalid file and continue to the next one
            }

            // Check for valid file size
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Tệp quá lớn. Kích thước tối đa là 10MB.',
                });
                continue; // Skip large file and continue to the next one
            }

            // If the file is valid, preview it
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create a container div for the image and the remove button
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('relative', 'm-2');
                
                // Create the image element
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Uploaded Image';
                img.classList.add('w-24', 'h-24', 'object-cover', 'rounded-lg');

                // Create the "X" button using a <span> element
                const removeButton = document.createElement('span');
                removeButton.textContent = 'X';
                removeButton.classList.add('w-5/12', 'h-5/12' ,'absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'p-1', 'cursor-pointer', 'font-bold', 'text-xl');
                
                // Add click event to remove the image container and update images array
                removeButton.onclick = function() {
                    // Find the index of the image in the images array
                    const imageIndex = images.findIndex(image => image.src === img.src);
                    
                    if (imageIndex !== -1) {
                        // Remove the image from the images array
                        images.splice(imageIndex, 1);
                    }
                    
                    // Remove the image container from the DOM
                    previewContainer.removeChild(imgContainer);
                };

                // Append the image and "X" button to the container
                imgContainer.appendChild(img);
                imgContainer.appendChild(removeButton);

                // Append the container to the preview area
                previewContainer.appendChild(imgContainer);

                // Add the valid image to the images array
                images.push({ src: e.target.result, file: file });
            }
            reader.readAsDataURL(file);
        }
    }



    function validCreateForm() {
        let isValid = true;
        const inputFields = document.querySelectorAll("input, select");  // Select all input and select fields
        const imageUploadZone = document.getElementById("imagesZone");  // The container for images
        let firstInvalidField = null;  // To keep track of the first invalid field

        // Clear previous validation styles
        inputFields.forEach(field => {
            field.classList.remove("border-red-500");  // Remove red border from all inputs
            field.classList.remove("focus:ring-red-500");  // Remove red focus ring
        });

        // Validate Fullname
        const fullname = document.getElementById("fullname").value;
        if (!fullname || fullname.length > 255) {
            showError('Họ tên không được để trống và không quá 255 ký tự.', document.getElementById("fullname"));
            isValid = false;
            if (!firstInvalidField) firstInvalidField = document.getElementById("fullname");
        }

        // Validate Phone
        const phone = document.getElementById("phone").value;
        if (!phone) {
            showError('Số điện thoại không được để trống.', document.getElementById("phone"));
            isValid = false;
            if (!firstInvalidField) firstInvalidField = document.getElementById("phone");
        }

        // Validate Email
        const email = document.getElementById("email").value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!email || !emailPattern.test(email)) {
            showError('Địa chỉ email không hợp lệ.', document.getElementById("email"));
            isValid = false;
            if (!firstInvalidField) firstInvalidField = document.getElementById("email");
        }

        // Validate Birthday
        const birthday = document.getElementById("birthday").value;
        const today = new Date().toISOString().split('T')[0]; // Get current date in 'YYYY-MM-DD' format
        if (!birthday) {
            showError('Ngày sinh không được để trống.', document.getElementById("birthday"));
            isValid = false;
            if (!firstInvalidField) firstInvalidField = document.getElementById("birthday");
        } else if (birthday > today) {
            showError('Ngày sinh không thể là ngày trong tương lai.', document.getElementById("birthday"));
            isValid = false;
            if (!firstInvalidField) firstInvalidField = document.getElementById("birthday");
        }

        // Validate at least one image is uploaded
        if (!imageUploadZone.querySelector("img")) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Bạn phải tải ít nhất một ảnh lên để tạo profile.',
            });
            isValid = false;
        }

        // Focus on the first invalid field
        if (firstInvalidField) {
            firstInvalidField.focus();  // Focus on the first invalid field
        }

        return isValid;
    }

    // Function to show error and highlight the invalid input field
    function showError(message, field) {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: message,
        });
        // Add red border and focus ring to the invalid field
        field.classList.add("border-red-500", "focus:ring-red-500");
    }


    // Function to call the API for creating a profile
    function callAPICreate() {

        // Create FormData object to send only the changed fields
        let formData = new FormData();

        // Get values from the form
        const newBirthday = document.getElementById("birthday").value;
        formData.append("birthday", newBirthday);

        const gender = document.getElementById("gender").value;
        formData.append("gender", gender);

        const newFullname = document.getElementById("fullname").value;
        formData.append("fullname", newFullname);

        const newPhone = document.getElementById("phone").value;
        formData.append("phone", newPhone);

        const newEmail = document.getElementById("email").value;
        formData.append("email", newEmail);

        const position = document.getElementById("position").value;
        formData.append("position", position);

        console.log(images);

        // Handle file uploads for images (if any)
        if (images.length > 0) {
            for (let i = 0; i < images.length; i++) {
                formData.append("images", images[i].file);
            }
        }

        // Send the data via AJAX request
        $.ajax({
            url: 'http://localhost:8080/api/Profile/Create', // Ensure this matches the correct endpoint
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
                Swal.fire({
                    icon: 'success',
                    title: 'Khởi tạo thành công!',
                    text: 'Thông tin nhân viên đã được thêm vào hệ thống.',
                }).then(() => {
                    window.location.href = '/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra khi thêm vào hệ thống thông tin.',
                });
            }
        });

    }


   
</script>
        
</body>

</html>


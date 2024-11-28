<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Check-In/Check-Out</title>
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">

    <style>
        body{
            overflow: hidden; /* Disable both horizontal and vertical scrolling */
        }

        /* Container styling */
        .container {
            background-color: #edf3ff;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }


        /* Input group styling */
        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .input-box {
            font-size: 20px;
            background-color: #dcd8f0;
            border-radius: 12px;
            width: 45%;
            color: #6d5a8d;
            font-weight: bold;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
        }


        /* Button styling */
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            height: 60px;
        }

        .btn {
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            width: 45%;
        }

        .btn-checkin {
            background-color: #4c3ff5;
        }

        .btn-checkin:hover {
            background-color: #3a2ecc;
        }

        .btn-checkout {
            background-color: #8b5aff;
        }

        .btn-checkout:hover {
            background-color: #6d47cc;
        }

        .image {
            height: 200px;
        }

        #listStaff, #listShift {
            width: 45%;
            height: 380px; /* Adjust to limit the height */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Disable horizontal scrolling */
            padding: 10px; /* Optional: Add inner spacing */
            border: 1px solid #ddd; /* Optional: Add a border for clarity */
            border-radius: 8px; /* Optional: Rounded corners */
            background-color: #f9f9f9; /* Optional: Light background color */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                href="/SystemSecuritySGU/SS_FrontEnd/EmployeeUI/CheckIn-CheckOut/CheckIn-CheckOut.php" 
                class="ml-4 font-medium text-gray-500 hover:text-gray-700"
                style="font-size: 14px"
                >
                Check-in & check-out
                </a>
            </div>
            </li>

        </ol>
    </nav>   

    <div class="w-screen p-12 pt-6">

        <div class="input-group">
            <div class="input-box ID">Ca làm hôm nay</div>
            <div class="input-box name">Danh sách nhân viên</div>
        </div>

        <div class="input-group ">
            <div id="listShift"></div>
            <div id="listStaff"></div>
        </div>
        
        <div class="buttons">
            <button class="btn btn-checkin">Check in</button>
            <button class="btn btn-checkout">Check out</button>
        </div>
    </div>

    <script>

        var shiftId = 0;
        var profileCode = "";

        document.addEventListener("DOMContentLoaded", () => {
            loadShiftsForToday();
        });

        function loadShiftsForToday() {
            const today = new Date();
            const todayDate = today.toISOString().split('T')[0]; // Định dạng YYYY-MM-DD cho ngày hôm nay

            $.ajax({
                url: 'http://localhost:8080/api/Shift/List',
                type: 'GET',
                dataType: "json",
                data: {
                    targetDate: todayDate,
                    status: true,
                    pageNumber: 1,
                    pageSize: 10
                },
                success: function(response) {
                    console.log(response.data.content);

                    // Get the list of shifts
                    const shifts = response.data.content;

                    // Get the container
                    const listShiftContainer = $("#listShift");

                    // Clear the container
                    listShiftContainer.empty();

                    // Generate HTML for each shift
                    if (shifts && shifts.length > 0) {
                        shifts.forEach(shift => {
                            const shiftHtml = `
                                <div class="shift-item bg-gray-100 p-4 rounded-md shadow-md my-4 flex items-center">
                                    <input type="radio" name="shiftRadio" id="shift-${shift.id}" value="${shift.id}" class="mr-4">
                                    <label for="shift-${shift.id}" class="flex-1">
                                        <h4 class="text-lg font-semibold text-blue-500">${shift.shiftName}</h4>
                                        <p class="text-sm text-gray-700">Start: ${shift.startTime}</p>
                                        <p class="text-sm text-gray-700">End: ${shift.endTime}</p>
                                    </label>
                                </div>
                            `;
                            listShiftContainer.append(shiftHtml);
                        });

                        // Attach event listener to the radio buttons
                        $("input[name='shiftRadio']").change(function() {
                            const selectedShiftId = $(this).val();
                            loadEmployeesForShift(selectedShiftId);
                            shiftId = selectedShiftId;
                        });
                    } else {
                        listShiftContainer.html('<p class="text-gray-500 text-center">Không có ca làm nào trong ngày !.</p>');
                    }
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.error ?
                        Object.values(xhr.responseJSON.error).join(", ") :
                        'Không thể tải danh sách ca làm.';
                    Swal.fire('Lỗi', errorMsg, 'error');
                }
            });
        }

        function loadEmployeesForShift(shiftCode) {
            $.ajax({
                url: `http://localhost:8080/api/Shift/Detail?id=${shiftCode}`,
                type: 'GET',
                dataType: "json",
                success: function(response) {
                    // Get the list of staff (response.data.signUps)
                    const staffList = response.data.signUps;

                    // Get the container
                    const listStaffContainer = $("#listStaff");

                    // Clear the container
                    listStaffContainer.empty();

                    // Generate HTML for each staff member
                    if (staffList && staffList.length > 0) {
                        staffList.forEach(staff => {
                            const staffHtml = `
                                <div class="staff-item bg-gray-100 p-4 rounded-md shadow-md my-4 flex items-center">
                                    <input 
                                        type="radio" 
                                        name="staffRadio" 
                                        value="${staff.profile.code}" 
                                        id="staff-${staff.profile.code}" 
                                        class="mr-4"
                                    />
                                    <label for="staff-${staff.profile.code}" class="flex items-center w-full">
                                        <img 
                                            src="/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/16b2e2579118bf6fba3b56523583117f.jpg" 
                                            alt="${staff.profile.code}" 
                                            class="w-12 h-12 rounded-full mr-4"
                                        />
                                        <div>
                                            <h4 class="text-lg font-semibold text-blue-500">${staff.profile.code}</h4>
                                            <p class="text-sm text-gray-700">Họ và tên: ${staff.profile.fullname}</p>
                                        </div>
                                    </label>
                                </div>
                            `;

                            listStaffContainer.append(staffHtml);
                        });

                        // Add event listener for dynamically created radio inputs
                        listStaffContainer.on("change", "input[name='staffRadio']", function(event) {
                            const selectedStaffCode = event.target.value;
                            profileCode = selectedStaffCode;
                        });

                    } else {
                        listStaffContainer.html('<p class="text-gray-500">Không có nhân viên nào được đăng ký.</p>');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Có lỗi xảy ra khi tải danh sách nhân viên.', 'error');
                }
            });
        }



        $(document).on("click", ".btn-checkin, .btn-checkout", function () {
            const actionType = $(this).hasClass("btn-checkin") ? "Check In" : "Check Out";

            // Show the form
            Swal.fire({
                title: `${actionType} - xác thực sinh trắc học`,
                html: `
                    <div id="upload-container">
                        <div id="drop-zone" class="mt-2 flex-row justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div id="preview-container" class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 text-sm text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Tải ảnh</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only" onchange="handleSingleFileSelect(event)">
                                    </label>
                                    <p class="pl-1">hoặc kéo thả ảnh</p>
                                </div>
                                <p class="text-xs text-gray-600">PNG, JPG, GIF tối đa 10MB</p>
                            </div>
                            <div id="preview-area" class="flex justify-center mt-4"></div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: actionType,
                preConfirm: () => {
                    const selectedFile = images.length > 0 ? images[0].file : null;
                    if (!selectedFile) {
                        Swal.showValidationMessage("Bạn không được để trống ảnh.");
                        return false;
                    }
                    return selectedFile;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Prepare data for API call
                    const formData = new FormData(); "20"
                    formData.append("shiftId", parseInt(shiftId, 10) );
                    formData.append("profileCode", profileCode);
                    formData.append("image", result.value);

                    // Determine API endpoint
                    const apiUrl =
                        actionType === "Check In"
                            ? "http://localhost:8080/api/CheckIn/Create"
                            : "http://localhost:8080/api/CheckOut/Create";

                    // Make API request
                    $.ajax({
                        url: apiUrl,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () {
                            Swal.fire("Success", `${actionType} thành công.`, "success");
                        },
                        error: function (error) {
                            Swal.fire(actionType, `${error.responseJSON.detailMessage}`, "error");
                        }
                    });
                }
            });

            // Add drag-and-drop functionality
            const dropZone = document.getElementById("drop-zone");
            dropZone.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropZone.classList.add("border-indigo-600");
            });

            dropZone.addEventListener("dragleave", () => {
                dropZone.classList.remove("border-indigo-600");
            });

            dropZone.addEventListener("drop", (e) => {
                e.preventDefault();
                dropZone.classList.remove("border-indigo-600");
                const files = e.dataTransfer.files;
                handleSingleFileSelect({ target: { files } });
            });
        });

        // Update global `images` array to handle a single file
        let images = [];

        function handleSingleFileSelect(event) {
            const files = event.target.files;
            validateSingleFile(files);
        }

        function validateSingleFile(files) {
            const allowedExtensions = ["image/jpeg", "image/png", "image/gif"];
            const maxSize = 10 * 1024 * 1024; // 10 MB
            const previewArea = document.getElementById("preview-area");

            // Clear previous images
            previewArea.innerHTML = "";
            images = [];

            for (const file of files) {
                if (!allowedExtensions.includes(file.type)) {
                    Swal.fire("Error", "File ảnh không hợp lệ, chỉ chấp nhận JPG, PNG, GIF", "error");
                    return;
                }
                if (file.size > maxSize) {
                    Swal.fire("Error", "Ảnh không được vượt quá 10MB.", "error");
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.alt = "Uploaded Image";
                    img.classList.add("w-32", "h-32", "object-cover", "rounded-lg");

                    previewArea.appendChild(img);
                    images.push({ src: e.target.result, file });
                };
                reader.readAsDataURL(file);

                document.getElementById("preview-container").style.display = "none";

            }
        }


    </script>
</body>
</html>
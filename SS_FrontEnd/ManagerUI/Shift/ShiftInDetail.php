<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SockJS -->
    <script src="https://cdn.jsdelivr.net/npm/sockjs-client@1/dist/sockjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/stompjs/lib/stomp.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <title>Shift Detail</title>
    <link rel="stylesheet" href="./ShiftInDetail.css">

    <style>
        /* Notification Styles */
        #notification {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none; /* Hidden by default */
            z-index: 1000; /* Ensure it appears on top */
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>

    <div id="notification"></div> <!-- Notification Area -->


    <?php include_once '/xampp/htdocs/SystemSecuritySGU/SS_FrontEnd/Header.php'; ?>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="flex border-b border-gray-200 bg-white" aria-label="Breadcrumb">
        <ol role="list" class="mx-auto flex w-full max-w-screen-xl space-x-4 px-4 sm:px-6 lg:px-8">
            
            <!-- Home breadcrumb -->
            <li class="flex">
            <div class="flex items-center">
                <a href="/SystemSecuritySGU/SS_FrontEnd/HomePage.php" class="text-gray-400 hover:text-gray-500">
                <!-- Heroicon name: mini/home -->
                <svg 
                    class="h-5 w-5 flex-shrink-0" 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 20 20" 
                    fill="currentColor" 
                    aria-hidden="true"
                >
                    <path 
                    fill-rule="evenodd" 
                    d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" 
                    clip-rule="evenodd"
                    />
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
                aria-hidden="true"
                >
                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                </svg>
                <a 
                href="/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php" 
                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                >
                Quản lý ca làm
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

    <div class="container mx-auto" >

        




        <div class="sub-component">
            <div class="shift-info">
                <h2 style="font-size: 20px;  margin-top: 15px;">Thông tin chi tiết ca làm</h2>
                <p>ID: <span id="shiftId"></span></p>
                <p>Giờ vào: <span id="startTime"></span></p>
                <p>Giờ tan ca: <span id="endTime"></span></p>
                <p>Giờ nghỉ trưa: <span id="breakStartTime"></span></p>
                <p>Kết thúc nghỉ trưa: <span id="breakEndTime"></span></p>
                <p>Số nhân viên: <span id="totalEmployees"></span></p>
            </div>
            <div class="employee-list">
                <h3 style="font-size: 20px; ">Danh sách nhân viên</h3>
                <table id="employeeTable">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Tên nhân viên</th>
                            <th>Status</th>
                            <th>Check-in Status</th>
                            <th>Thời gian check-in</th>
                            <th>Check-out Status</th>
                            <th>Thời gian check-out</th>
                        </tr>
                    </thead>
                    <tbody id="employeeList"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var shiftId = <?php echo $_GET['shiftId']; ?>;
        var token = localStorage.getItem('token');

        let profileDataMap = {};
        let checkInDataMap = {};
        let checkOutDataMap = {};

        // Fetch shift details
        getShiftInDetail(shiftId);
        setupWebSocket();  // Set up WebSocket connection

        function getShiftInDetail(shiftId) {
            $.ajax({
                url: `http://localhost:8080/api/Shift/Detail?id=${shiftId}`,
                type: 'GET',
                dataType: "json",
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        const data = response.data;

                        $("#shiftId").text(data.id);
                        $("#shiftName").text(data.shiftName);
                        $("#startTime").text(data.startTime);
                        $("#endTime").text(data.endTime);
                        $("#breakStartTime").text(data.breakStartTime);
                        $("#breakEndTime").text(data.breakEndTime);
                        $("#totalEmployees").text(data.signUps.length);

                        data.signUps.forEach(signUp => {
                            profileDataMap[signUp.profile.code] = signUp.profile;
                        });

                        getCheckInList(shiftId);
                    } else {
                        alert('Error: Shift details not found.');
                    }
                },
                error: function() {
                    alert('Error: Unable to fetch shift details.');
                }
            });
        }

        function getCheckInList(shiftId) {
            $.ajax({
                url: `http://localhost:8080/api/CheckIn/List?shiftId=${shiftId}`,
                type: 'GET',
                dataType: "json",
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(checkIn => {
                            checkInDataMap[checkIn.profile.code] = checkIn;
                        });
                        getCheckOutList(shiftId); // Fetch checkout data after check-in data
                    } else {
                        alert('Error: Check-in list not found.');
                    }
                },
                error: function() {
                    alert('Error: Unable to fetch check-in list.');
                }
            });
        }

        function getCheckOutList(shiftId) {
            $.ajax({
                url: `http://localhost:8080/api/CheckOut/List?shiftId=${shiftId}`,
                type: 'GET',
                dataType: "json",
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    if (response.status === 200 && response.data) {
                        response.data.forEach(checkOut => {
                            checkOutDataMap[checkOut.profile.code] = checkOut;
                        });
                        displayEmployeeList();
                    } else {
                        alert('Error: Check-out list not found.');
                    }
                },
                error: function() {
                    alert('Error: Unable to fetch check-out list.');
                }
            });
        }

        function displayEmployeeList() {
            const employeeList = document.getElementById('employeeList');
            employeeList.innerHTML = '';

            for (const profileCode in profileDataMap) {
                const profile = profileDataMap[profileCode];
                const checkIn = checkInDataMap[profileCode];
                const checkOut = checkOutDataMap[profileCode];

                let checkInStatus, checkInColor, checkInTime;
                if (checkIn) {
                    checkInTime = checkIn.checkInTime;
                    checkInStatus = checkIn.status === 'OnTime' ? 'Đúng giờ' : 'Trễ';
                    checkInColor = checkIn.status === 'OnTime' ? 'green' : 'red';
                } else {
                    checkInStatus = 'Chưa check in';
                    checkInColor = 'gray';
                    checkInTime = 'N/A';
                }

                let checkOutStatus, checkOutColor, checkOutTime;
                if (checkOut) {
                    checkOutTime = checkOut.checkOutTime;
                    checkOutStatus = checkOut.status === 'OnTime' ? 'Đúng giờ' : 'Vế sớm';
                    checkOutColor = checkOut.status === 'OnTime' ? 'green' : 'red';
                } else {
                    checkOutStatus = 'Chưa check out';
                    checkOutColor = 'gray';
                    checkOutTime = 'N/A';
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${profile.code}</td>
                    <td>${profile.fullname}</td>
                    <td>${profile.status === 'true' ? 'Active' : 'Inactive'}</td>
                    <td style="color: ${checkInColor};">${checkInStatus}</td>
                    <td>${checkInTime}</td>
                    <td style="color: ${checkOutColor};">${checkOutStatus}</td>
                    <td>${checkOutTime}</td>
                `;

                employeeList.appendChild(row);
            }
        }

        function setupWebSocket() {
            console.log("Setting up WebSocket...");
            const socket = new SockJS('http://localhost:8080/ws');
            const stompClient = Stomp.over(socket);

            stompClient.connect({}, (frame) => {
                console.log("WebSocket connected: ", frame);
                
                stompClient.subscribe('/topic/checkInUpdates', (message) => {
                    const data = JSON.parse(message.body);
                    showNotification(`${data.profile.fullname} đã check in lúc ${data.checkInTime}`);
                    getCheckInList(shiftId); // Reload CheckIn list on update
                });

                stompClient.subscribe('/topic/checkOutUpdates', (message) => {
                    const data = JSON.parse(message.body);
                    showNotification(`${data.profile.fullname} đã check out lúc ${data.checkOutTime}`);
                    getCheckOutList(shiftId); // Reload CheckOut list on update
                });
            }, (error) => {
                console.error("WebSocket connection error:", error);
            });
        }

        function showNotification(message) {
            const notification = $('#notification');
            notification.text(message);
            notification.fadeIn(200).delay(1500).fadeOut(200); // Show for 3 seconds
        }
    </script>
</body>
</html>

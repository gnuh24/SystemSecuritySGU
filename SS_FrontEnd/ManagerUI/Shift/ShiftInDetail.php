<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SockJS -->
    <script src="https://cdn.jsdelivr.net/npm/sockjs-client@1/dist/sockjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/stompjs/lib/stomp.min.js"></script>
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

    <div class="shift-card">
        <hr class="horizontal-line">
        <h2 id="shiftName">Shift Name</h2>
        <hr class="horizontal-line">

        <div class="sub-component">
            <div class="shift-info">
                <h3>Thông tin chi tiết ca làm</h3>
                <p><strong>ID:</strong> <span id="shiftId"></span></p>
                <p><strong>Giờ vào:</strong> <span id="startTime"></span></p>
                <p><strong>Giờ tan ca:</strong> <span id="endTime"></span></p>
                <p><strong>Giờ nghỉ trưa:</strong> <span id="breakStartTime"></span></p>
                <p><strong>Kết thúc nghỉ trưa:</strong> <span id="breakEndTime"></span></p>
                <p><strong>Số nhân viên:</strong> <span id="totalEmployees"></span></p>
            </div>

            <div class="employee-list">
                <h3>Danh sách nhân viên</h3>
                <table id="employeeTable">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Check-in Status</th>
                            <th>Check-in Time</th>
                            <th>Check-out Status</th>
                            <th>Check-out Time</th>
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

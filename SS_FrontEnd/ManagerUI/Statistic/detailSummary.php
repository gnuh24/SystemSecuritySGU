<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê giờ làm việc</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<style>
       .burning-effect {
            color: #6f6f6f;
            font-weight: bold;
            animation: burn 1.5s infinite;
        }

        @keyframes burn {
            0% { text-shadow: 0 0 5px red, 0 0 10px orange; }
            50% { text-shadow: 0 0 10px red, 0 0 20px orange; }
            100% { text-shadow: 0 0 5px red, 0 0 10px orange; }
        }
</style>
<body>
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
                Báo cáo
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
                id = "target"
                href="#" 
                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                >
              
                </a>
            </div>
            </li>

        </ol>
    </nav>



    <div class="w-3/4 mx-auto mt-6">
        <table id="shiftTable" class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border text-left">Check-in Time</th>
                    <th class="px-4 py-2 border text-left">Check-out Time</th>
                    <th class="px-4 py-2 border text-left">Shift Start Time</th>
                    <th class="px-4 py-2 border text-left">Shift End Time</th>
                    <th class="px-4 py-2 border text-left">Check-in Status</th>
                    <th class="px-4 py-2 border text-left">Check-out Status</th>
                    <th class="px-4 py-2 border text-left">Loại ca làm</th>
                </tr>
            </thead>
            <tbody id="shiftTableBody">
                <!-- Rows will be populated here via JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
    const token = localStorage.getItem("token");
    const profileCode = '<?php $_GET['profileCode']; ?>'
    const from = '<?php echo isset($_GET['from']) ? $_GET['from'] : ""; ?>';
    const to = '<?php echo isset($_GET['to']) ? $_GET['to'] : ""; ?>';
    var data = null;

    fetchData();

    function callApi(url) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function (response) {
                    if (response.status === 200) {
                        // Process response data
                        data = response.data;                        

                        resolve(); // Resolve when data is successfully processed
                    } else {
                        console.error("Error: ", response.message);
                        reject(response.message); // Reject with error message
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                    reject(error); // Reject with error details
                }
            });
        });
    }


    function fetchData() {
        let url = `http://localhost:8080/api/Statistic/ShiftDetail?profileCode=NV00000001&`;

        if (from && to) {
            url += `startDate=${from}&endDate=${to}`;
        } else if (from) {
            url += `startDate=${from}`;
        } else if (to) {
            url += `endDate=${to}`;
        }

        // Wait for the API data to load before updating the table
        callApi(url)
        .then(() => {
            console.log("Data fetched successfully, updating table.");
            updateTable(data);
        })
        .catch((error) => {
            console.error("Failed to fetch data:", error);
        });
    }

    function updateTable(data) {
        // Get the table body element
        const tableBody = document.getElementById('shiftTableBody');

        // Clear any existing rows
        tableBody.innerHTML = '';
        var code = "";
        var name = "";

        
        // Loop through the fetched data and create rows
        data.forEach(shift => {
            // Create a new row
            const row = document.createElement('tr');

            code = shift.profileCode;
            name = shift.profileName;

            row.innerHTML = `
                <td class="px-4 py-2 border ${shift.checkInTime ? "" : "burning-effect"}">
                    ${shift.checkInTime || "Chưa check-in"}
                </td>
                <td class="px-4 py-2 border ${shift.checkOutTime ? "" : "burning-effect"}">
                    ${shift.checkOutTime || "Chưa check-out"}
                </td>
                <td class="px-4 py-2 border">${shift.shiftStartTime || "N/A"}</td>
                <td class="px-4 py-2 border">${shift.shiftEndTime || "N/A"}</td>
                 <td class="px-4 py-2 border ${shift.checkInStatus ? "" : "burning-effect"}">
                    ${shift.checkInStatus || "Chưa check-in"}
                </td>
                <td class="px-4 py-2 border ${shift.checkOutStatus ? "" : "burning-effect"}">
                    ${shift.checkOutStatus || "Chưa check-out"}
                </td>
                <td class="px-4 py-2 border">${shift.isOvertime ? "OT" : "Tiêu chuẩn"}</td>
            `;

            // Append the row to the table body
            tableBody.appendChild(row);
        });

        document.getElementById("target").textContent = `${code} - ${name}`;

    }



</script>



 
</body>

</html>
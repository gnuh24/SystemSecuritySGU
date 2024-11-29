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
                href="#" 
                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                >
              
                </a>
            </div>
            </li>

        </ol>
    </nav>



    <div class="w-3/4 mx-auto">
        <canvas id="myChart" class="w-full h-96"></canvas>
    </div>

    <script>
    const token = localStorage.getItem("token");

    var from = "";
    var to = "";

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
                        const data = response.data;
                        labels = data.map(item => item.profileName);
                        totalHoursWorkedOfficial = data.map(item => item.totalHoursWorkedOfficial);
                        totalHoursWorkedOT = data.map(item => item.totalHoursWorkedOT);
                        totalLateMinutes = data.map(item => item.totalLateMinutes);
                        totalEarlyLeavingMinutes = data.map(item => item.totalEarlyLeavingMinutes);
                        totalWorkedShifts = data.map(item => item.totalWorkedShifts);
                        totalMissedShifts = data.map(item => item.totalMissedShifts);

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
        let url = `http://localhost:8080/api/Statistic/ProfileWorkSummary`;

        if (from && to) {
            url += `?startDate=${from}&endDate=${to}`;
        } else if (from) {
            url += `?startDate=${from}`;
        } else if (to) {
            url += `?endDate=${to}`;
        }

        // Wait for the API data to load before updating the chart
        callApi(url)
            .then(() => {
                console.log("Data fetched successfully, updating chart.");
                updateChart();
            })
            .catch((error) => {
                console.error("Failed to fetch data:", error);
            });
    }


    // Event listeners for date inputs
    document.getElementById('fromDate').addEventListener('change', function (event) {
        from = event.target.value;
        fetchData(); // Call API when the "from" date changes
    });

    document.getElementById('toDate').addEventListener('change', function (event) {
        to = event.target.value;
        fetchData(); // Call API when the "to" date changes
    });

    // Data for the chart (empty initially)
    var labels = [];
    var totalHoursWorkedOfficial = [];
    var totalHoursWorkedOT = [];
    var totalLateMinutes = [];
    var totalEarlyLeavingMinutes = [];
    var totalWorkedShifts = [];
    var totalMissedShifts = [];
    var myChart = null;


    function updateChart() {

        // Check if the chart already exists and destroy it
        if (myChart) {
            myChart.destroy();
        }

        // Chart data
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Số giờ làm chính thức',
                    data: totalHoursWorkedOfficial,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue
                    stack: 'Stack 0',
                },
                {
                    label: 'Số giờ làm tăng ca',
                    data: totalHoursWorkedOT,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)', // Red
                    stack: 'Stack 0',
                },
                {
                    label: 'Số phút đi trễ',
                    data: totalLateMinutes,
                    backgroundColor: 'rgba(152, 99, 132, 0.7)', // Red
                    stack: 'Stack 1',
                },
                {
                    label: 'Số phút về sớm',
                    data: totalEarlyLeavingMinutes,
                    backgroundColor: 'rgba(152, 15, 132, 0.7)', // Red
                    stack: 'Stack 1',
                },
            ]
        };

        // Chart configuration
        const config = {
            type: 'bar',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Work Hours by Profile - Stacked'
                    },
                },
                responsive: true,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        };

        // Render the new chart
        const ctx = document.getElementById('myChart').getContext('2d');
        myChart = new Chart(ctx, config); // Save the chart instance to `window.myChart`
    }

</script>



 
</body>

</html>
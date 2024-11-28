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

        </ol>
    </nav>

    <div class="w-3/4 mx-auto mt-4">
        <label for="fromDate">From:</label>
        <input type="date" id="fromDate" class="border rounded p-2 mx-2" />

        <label for="toDate">To:</label>
        <input type="date" id="toDate" class="border rounded p-2 mx-2" />
    </div>

    <div class="w-3/4 mx-auto">
        <canvas id="myChart" class="w-full h-96"></canvas>
    </div>

    <script>
    const token = localStorage.getItem("token");

    var officialSummary = null;
    var otSummary = null;

    var from = "";
    var to = "";

    fetchData();

    // Function to call API
    function callApi(url) {
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function (response) {
                if (url.includes("ProfileWorkSummary") && !url.includes("ProfileWorkSummaryOT")) {
                    officialSummary = response;
                    labels = officialSummary.data.map(item => item.profileName);
                    totalHoursWorkedOfficial = officialSummary.data.map(item => item.totalHoursWorkedOfficial);

                } else if (url.includes("ProfileWorkSummaryOT")) {
                    otSummary = response;
                    totalHoursWorkedOT = otSummary.data.map(item => item.totalHoursWorkedOT);

                }
                // After fetching data, update the chart
                updateChart();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data from:", url, error);
            }
        });
    }

    // Function to trigger API calls based on date inputs or default
    function fetchData() {
        let url1;
        let url2;

        if (from && to) {
            url1 = `http://localhost:8080/api/Statistic/ProfileWorkSummary?startDate=${from}&endDate=${to}`;
            url2 = `http://localhost:8080/api/Statistic/ProfileWorkSummaryOT?startDate=${from}&endDate=${to}`;
        } else if (from) {
            url1 = `http://localhost:8080/api/Statistic/ProfileWorkSummary?startDate=${from}`;
            url2 = `http://localhost:8080/api/Statistic/ProfileWorkSummaryOT?startDate=${from}`;
        } else if (to) {
            url1 = `http://localhost:8080/api/Statistic/ProfileWorkSummary?endDate=${to}`;
            url2 = `http://localhost:8080/api/Statistic/ProfileWorkSummaryOT?endDate=${to}`;
        } else {
            url1 = `http://localhost:8080/api/Statistic/ProfileWorkSummary`;
            url2 = `http://localhost:8080/api/Statistic/ProfileWorkSummaryOT`;
        }

        // Call the APIs
        callApi(url1);
        callApi(url2);
    }

    // Event listeners for date inputs
    document.getElementById('fromDate').addEventListener('change', function (event) {
        from = event.target.value;
        fetchData(); // Call APIs when the "from" date changes
    });

    document.getElementById('toDate').addEventListener('change', function (event) {
        to = event.target.value;
        fetchData(); // Call APIs when the "to" date changes
    });

    // Data for the chart (empty initially)
    var labels = [];
    var totalHoursWorkedOfficial = [];
    var totalHoursWorkedOT = [];

    function updateChart() {
        // Reset the arrays to update the chart data

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

        // Render the chart
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, config);
    }
</script>


 
</body>

</html>
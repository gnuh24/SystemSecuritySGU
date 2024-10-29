<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="ManagerHomePageUI.css">

    <!-- jQuery library (for Ajax) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="manager-dashboard">
        <h1>Manager Dashboard</h1>
        <div class="manager-content">
            <div class="manage-buttons">
                <button id="manage-profiles">Manage Profiles</button>
                <button id="manage-shifts">Manage Shifts</button>
                <button id="statistics">Statistic</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Sự kiện khi nhấn nút Manage Profiles
            $('#manage-profiles').click(function() {
                window.location.href = "../Profile/QLProfile.php";
            });

            // Sự kiện khi nhấn nút Manage Shifts
            $('#manage-shifts').click(function() {
                window.location.href = "../Shift/QLShift.php";
            });

            // Sự kiện khi nhấn nút Statistics
            $('#statistics').click(function() {
                window.location.href = "../Statistic/statistic.php";
            });
        });
    </script>

</body>

</html>
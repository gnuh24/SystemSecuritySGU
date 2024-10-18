<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="ManagerHomePageUI.css">
</head>
<body>
    <div class="manager-dashboard">
        <h1>Manager Dashboard</h1>
        <div class="manager-content">
            <div class="manage-buttons">
                <button id="manage-profiles">Manage Profiles</button>
                <button>Manage Shifts</button>
                <button>Statistic</button>
            </div>
        </div>
    </div>

    <script>
        // Sự kiện khi nhấn nút Manage Profiles
        document.getElementById("manage-profiles").addEventListener("click", function() {
            window.location.href = "../Profile/QLProfile.php";  // Di chuyển đến trang QLProfile.php
        });
    </script>
</body>
</html>

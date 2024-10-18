<?php
    // Start session to store login information
    session_start();
    ob_start();
    include "../Login/account.php";  // Ensure this path is correct

    $error = "";  // Initialize error message

    if((isset($_POST['login'])) && ($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Check the user credentials
        $role = checkUser($username, $password);

        // If the role is found
        if ($role) {
            $_SESSION['role'] = $role;
            
            // Redirect based on the role
            if ($role == 'Admin') {
                header("Location: ../AdminUI/Account.php");  // Redirect to Admin Dashboard
                exit();
            } else if ($role == 'Manager') {
                header("Location: ../ManagerUI/ManagerHomePageUI/ManagerHomePageUI.php");  // Redirect to Manager Dashboard
                exit();
            }
        } else {
            $error = "Username or password is incorrect.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./logo-removebg.png" type="image/x-icon">
    <title>Fingerprint Login</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>
    <div class="login-container">
        <h1>FINGERPRINT</h1>
        <div class="login-box">
            <div class="login-form">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" name="login" value="Login" class="btn_login">
                </form>
            </div>
            <div class="logo-box">
                <img src=".\logo-removebg.png" alt="Fingerprint Logo">
            </div>
        </div>
    </div>    
</body>
</html>

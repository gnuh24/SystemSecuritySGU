<?php
// Start session to store login information
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./logo-removebg.png" type="image/x-icon">
    <title>Fingerprint Login</title>
    <link rel="stylesheet" href="./login.css">

    <!-- jQuery library (for Ajax) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="login-container">
        <h1>FINGERPRINT</h1>
        <div class="login-box">
            <div class="login-form">
                <form id="loginForm">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <input type="submit" value="Login" class="btn_login">
                </form>
                <p id="error-message" style="color: red;"></p> <!-- Error message display -->
            </div>
            <div class="logo-box">
                <img src="./logo-removebg.png" alt="Fingerprint Logo">
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = new FormData(); // Create a form-data object
                formData.append('username', $('#username').val());
                formData.append('password', $('#password').val());

                $.ajax({
                    url: 'http://localhost:8080/api/Auth/Login', // API endpoint
                    type: 'POST',
                    data: formData,
                    processData: false, // Required for form-data
                    contentType: false, // Required for form-data
                    dataType: 'json', // Expect JSON response from the server

                    success: function(response) {
                        var data = response.data;
                        var role = data.role;

                        // Save user information in localStorage or sessionStorage
                        localStorage.setItem('userId', data.id); // or sessionStorage.setItem('userId', data.id);
                        localStorage.setItem('username', data.username); // or sessionStorage.setItem('username', data.username);
                        localStorage.setItem('role', role); // or sessionStorage.setItem('role', role);
                        localStorage.setItem('token', data.token); // or sessionStorage.setItem('token', data.token);
                        localStorage.setItem('tokenExpirationTime', data.tokenExpirationTime); // or sessionStorage.setItem('tokenExpirationTime', data.tokenExpirationTime);
                        localStorage.setItem('refreshToken', data.refreshToken); // or sessionStorage.setItem('refreshToken', data.refreshToken);
                        localStorage.setItem('refreshTokenExpirationTime', data.refreshTokenExpirationTime); // or sessionStorage.setItem('refreshTokenExpirationTime', data.refreshTokenExpirationTime);

                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: `Welcome ${role}`,
                            confirmButtonText: 'Continue'
                        }).then(() => {
                            if (role === 'Admin') {
                                window.location.href = '../AdminUI/Account.php'; // Redirect to Admin Dashboard
                            } else if (role === 'Manager') {
                                window.location.href = '../ManagerUI/ManagerHomePageUI/ManagerHomePageUI.php'; // Redirect to Manager Dashboard
                            } else {
                                window.location.href = '/default-redirect-page'; // Fallback for other roles
                            }
                        });
                    },

                    error: function(xhr, status, error) {
                        // Display error message from server or default message
                        var errorMessage = xhr.responseJSON?.detailMessage || 'Username or password is incorrect.';

                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: errorMessage,
                            confirmButtonText: 'Try Again'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
<?php
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'sgu_systemsecurity';
    $conn = new mysqli($server, $user, $pass, $database);
    if($conn){
        mysqli_query($conn, "SET NAMES 'utf8'");
        echo "Database connected successfully";
    }
    else {
        echo "Database connection failed";
    }
?>
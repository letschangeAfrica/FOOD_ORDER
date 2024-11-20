<?php
    //Start Session
    session_start();

    //Create Constants to store Non Repeating Valeurs

    define('SITEURL','http://localhost/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check if connection was successful
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }  //Database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_connect_error());
?>
<?php

        //Start Session
        session_start();

        //3. Execute query and save data in database
        define('SITEURL', 'http://localhost:8000/');
        define('LOCALHOST', '127.0.0.1');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'vjezba');

        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //Database connection
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //Selecting Database
?>
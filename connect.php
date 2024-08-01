<?php
   // Create connection
    $conn = new mysqli('localhost', 'root', '', 'log_in');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
?>

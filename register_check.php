<?php
    require 'enc_method.php'; // Make sure to include the file with the encryption functions

    $keyword = "PRETTYGIRLIEPOP"; // Replace with your keyword
    $shift = 8; // Define your shift value

    if (strlen($_POST["password"]) < 8) {
        header("Location: registration.php?error=password_length&username=" . urlencode($_POST['username']) . "&email=" . urlencode($_POST['email']));
        exit();
    }

    if ($_POST["password"] !== $_POST["confirm_password"]) {
        header("Location: registration.php?error=password_mismatch&username=" . urlencode($_POST['username']) . "&email=" . urlencode($_POST['email']));
        exit();
    }

    $conn = require __DIR__ . "/connect.php";

    // Check if username already exists
    $username = $_POST['username'];
    $check_query = "SELECT * FROM enc_dec WHERE username = ?";
    $check_stmt = $conn->prepare($check_query);

    if (!$check_stmt) {
        die("SQL error: " . $conn->error);
    }

    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Username already taken
        header("Location: registration.php?error=username_taken&email=" . urlencode($_POST['email']));
        exit();
    }

    // Encrypt username and password
    $encrypted_username = d_Encrypt($username, $keyword, $shift);
    $encrypted_password = d_Encrypt($_POST["password"], $keyword, $shift);

    // Insert new user if username is available
    $sql = "INSERT INTO enc_dec (username, email, password) VALUES (?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("SQL error: " . $conn->error);
        }

        $stmt->bind_param("sss", $encrypted_username, $_POST["email"], $encrypted_password);

        if ($stmt->execute()){
            header("Location: login.php");
            exit();
        } else {
            throw new Exception("Error inserting user: " . $stmt->error);
        }
    } catch (mysqli_sql_exception $e) {
        die($e->getMessage());
    }
?>

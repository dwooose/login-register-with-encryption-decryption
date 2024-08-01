<?php
    $conn = mysqli_connect("localhost", "root", "", "log_in");
    session_start();
    if(isset($_POST['submit'])) {
        if(empty($_POST["username"]) && empty($_POST["password"])){
            echo '<script>alert("Invalid login.")</script>';
        }else{
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $password = md5($password);
            $query = "INSERT INTO enc_dec (username, email, password) VALUES('$username', '$email',  '$password')";
            if(mysqli_query($conn, $query)){
                echo '<script>alert("Successfully registered.")</script>';
                header("location: login.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/register.css">
    <link rel="icon" href="images/logo2.png" type="image">
    <title>Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="register">
        <div class="box form-box">
            <div class="register_form">
                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">  
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?= htmlspecialchars(($_GET["username"] ?? "")) ?>" required>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'username_taken'): ?>
                            <p style="color: red; font-size: 0.8rem;">Username already taken.</p>
                        <?php endif; ?>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars(($_GET["email"] ?? "")) ?>" required>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'email_taken'): ?>
                            <p style="color: red; font-size: 0.8rem;">Email already taken.</p>
                        <?php endif; ?>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="<?= htmlspecialchars(($_GET["password"] ?? "")) ?>" required>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'password_length'): ?>
                            <p style="color: red; font-size: 0.8rem;">Password must be at least 8 characters.</p>
                        <?php endif; ?>
                    </div>
                    <div class="field input">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" value="<?= htmlspecialchars(($_GET["confirm_password"] ?? "")) ?>" required>
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'password_mismatch'): ?>
                            <p style="color: red; font-size: 0.8rem;">Passwords must match.</p>
                        <?php endif; ?>
                    </div>
                    <div class="field">
                        <input type="submit" class="button" name="submit" value="Sign Up" required>
                    </div>
                    <div class="links">
                        Already have an account yet? <a href="login.php">Login here!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

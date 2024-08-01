<?php
    $conn = mysqli_connect("localhost", "root", "", "log_in");
    session_start();
    
    if(isset($_POST['submit'])) {
        if(empty($_POST["username"]) && empty($_POST["password"])){
            echo '<script>alert("Invalid login.")</script>';
            
        }else{
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $password = md5($password);
            $query = "SELECT * FROM enc_dec WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($conn, $query);
            if(isset($_SESSION['username'])){
                header("location: home.php");
            }
            if(mysqli_num_rows($result) > 0){
                $_SESSION['username'] = $username;
                header("location: home.php");
            }else{
                echo '<script>alert("Invalid login.")</script>';
                
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="images/logo2.png" type="image">
    <title>Welcome</title>
</head>
<body>
    <div class="container">
        <div class="welcome-box">
            <h1>Welcome to <br><span>Jake's Coffee Shop</span>!</h1>
        </div>
        <div class="box form-box">
            <header>Log In</header>
            <form method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="field">
                    <input type="submit" class="login button" name="submit" value="Login" required>
                </div>

                <div class="links">
                    Don't have an account yet? <a href="registration.php">Register here!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

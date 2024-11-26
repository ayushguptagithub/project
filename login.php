<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-image: url(bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .parentDiv .divImg {
            height: 250px;
            background-image: url(bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .parentDiv {
            background-color: aliceblue;
            width: 30%;
            box-shadow: 10px 10px 50px;
        }
        .parentDiv .login {
            padding: 30px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            border-radius: 50px;
            background-color: lightcoral;
            height: 30px;
        }
        button {
            width: 100%;
            border-radius: 50px;
            background-color: rgb(87, 69, 255);
            height: 30px;
            color: aliceblue;    
        }
        .parentDiv .login .createName {
            text-align: center;
        }
        .parentDiv .login .twoText {
            display: flex;
            justify-content: space-between;
        }
        .main {
            display: flex;
            justify-content: center;
            margin-top: 3%;
        }
    </style>
</head>
<body>
<?php
session_start();
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set session variable
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to the main page
        exit();
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>


    <div class="main">
        <div class="parentDiv">
            <div class="divImg"></div>
            <div class="login">
                <h2>Login</h2>
                <?php if (!empty($error)): ?>
                    <p style="color: red; text-align: center;"><?= $error ?></p>
                <?php endif; ?>
                <form id="loginForm" method="POST" onsubmit="return validateForm()">
                    <input type="text" name="username" id="username" placeholder="Username"><br><br>
                    <input type="password" name="password" id="password" placeholder="Password"><br><br>
                    <div class="twoText">
                        <div>
                            <input type="checkbox" name="remember" id="remember"> Remember me
                        </div>
                        <a href="#">Forgot password?</a><br>
                    </div>
                    <br>
                    <button type="submit">Login</button><br><br>
                    <div class="createName">
                        <a href="signup.php" class="createName">Create an Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript validation for the login form
        function validateForm() {
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();

            if (username === "" || password === "") {
                alert("Both fields are required!");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

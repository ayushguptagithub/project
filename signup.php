<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
        input[type="text"], input[type="password"], select {
            width: 100%;
            border-radius: 50px;
            background-color: lightcoral;
            height: 30px;
            margin-bottom: 15px;
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
        .main {
            display: flex;
            justify-content: center;
            margin-top: 3%;
        }
    </style>
</head>
<body>
<?php
// Start session
session_start();

include "conn.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $usertype = trim($_POST['usertype']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($usertype)) {
        echo "<script>alert('All fields are required!'); window.location.href='signup.php';</script>";
        exit();
    } else if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long!'); window.location.href='signup.php';</script>";
        exit();
    }
    

    

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose another!')</script>";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, usertype) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $usertype);

        if ($stmt->execute()) {
            echo "<script>alert('Registered Successfully !!!'); window.location.href='login.php';</script>";
        exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>



    <div class="main">
        <div class="parentDiv">
            <div class="divImg"></div>
            <div class="login">
                <h2>Signup</h2>
                <form method="POST" action="">
                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <select name="usertype" required>
                        <option value="">Select Usertype</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                    <button type="submit">Signup</button>
                </form>
                <br>
                <div class="createName">
                    <a href="login.php" class="createName">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>

    <style>

        body

        {

            background-image: url(bg.jpg);

            background-repeat: no-repeat;

            background-size: cover;

        }

        .parentDiv .divImg

        {

            height: 250px;

            background-image: url(bg.jpg);

            background-repeat: no-repeat;

            background-size: cover;

            

        }

        .parentDiv{

            background-color: skyblue;

            width: 30%;

            box-shadow: 10px 10px 50px;

            

        }

        .parentDiv .Signup{

            padding: 30px;

        }

        input[type="text"]

        {

            width: 100%;

            border-radius: 50px;

            background-color: rgb(227, 127, 174);

            height: 30px;

            

        }

        input[type="password"]

        {

            width: 100%;

            border-radius: 50px;

            background-color:  rgb(227, 127, 174);

            height: 30px;

        }

        input[type="email"]

        {

            width: 100%;

            border-radius: 50px;

            background-color:  rgb(227, 127, 174);

            height: 30px;

        }

        button{

            width: 100%;

            border-radius: 50px;

            background-color: blueviolet;

            height: 30px;

            color: aliceblue;


        }

        .parentDiv .Signup .createName

        {

            text-align: center;


        }

        .parentDiv .Signup .twoText

        {

            display: flex;

            justify-content: space-between;


        }

        .main

        {

            /* background-color: antiquewhite; */

            display: flex;

            justify-content: center;

            margin-top: 3%;

            margin-bottom: 3%;


        }

        select {
            width: 100%;
            border-radius: 50px;
            background-color: lightcoral;
            height: 30px;
            margin-bottom: 15px;
        }

    </style>

</head>

<body>

<?php


include "conn.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $usertype = trim($_POST['usertype']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($usertype) || empty($name) || empty($email) || empty($confirmpassword)) {
        echo "<script>alert('All fields are required!'); window.location.href='signup.php';</script>";
        exit();
    } else if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long!'); window.location.href='signup.php';</script>";
        exit();
    }
    else if ($password != $confirmpassword){
        echo "<script>alert('Password and Confirm password doesnt match !'); window.location.href='signup.php';</script>";
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
        $stmt = $conn->prepare("INSERT INTO users (name,email, username, password, usertype) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss",$name , $email, $username, $password, $usertype);

        if ($stmt->execute()) {
            echo "<script>alert('Registered Successfully !!!'); window.location.href='login.php';</script>";
        exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }



}
    ?>

    <div class="main">

        <div class="parentDiv">


            <div class="divImg">

            </div>

    

    

            <div class="Signup">

                <h2>Sign in</h2>

                <form method="Post" action="">
                    <input type="text" name="name" placeholder="Name"><br><br>

                    <label for="email"></label>
                    <input type="email" id="email" name="email" placeholder="Email"><br><br>
                    <input type="text" name="username" id="" placeholder="Username"><br><br>
                    <input type="password" name="password" placeholder="Password"><br><br>
                    <input type="password" name="confirmpassword" placeholder=" Conform Password"><br><br>
                    <select name="usertype" required>
                        <option value="">Select Usertype</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                    <button type="submit">Sign-up</button><br><br>
                </form>

                <div class="createName">

                    <a href="" class="createName">Already have a account?</a><br>

    

                </div>

               

            </div>

    

        </div>

    </div>

    

</body>

</html>

<?php
include "conn.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch student data for editing
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    $student = $result->fetch_assoc();
    
    if (!$student) {
        echo "Student not found!";
        exit();
    }
}

// Update student data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $age = $_POST['age'];
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ?, age = ? WHERE id = ?");
    $stmt->bind_param("sssii", $name, $email, $course, $age, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php"); // Redirect to the main page after updating
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 600px;
        }
        header {
            text-align: center;
            margin: 20px 0;
        }
        h1 {
            color: #007BFF;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        form input, form select, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        form button {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        a.back-btn {
            color: #007BFF;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        a.back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Student</h1>
        </header>

        <!-- Edit Student Form -->
        <form method="POST">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <input type="text" name="name" placeholder="Student Name" value="<?= $student['name'] ?>" required>
            <input type="email" name="email" placeholder="Student Email" value="<?= $student['email'] ?>" required>
            <select name="course" required>
                <option value="Computer Science" <?= ($student['course'] == 'Computer Science') ? 'selected' : '' ?>>Computer Science</option>
                <option value="Engineering" <?= ($student['course'] == 'Engineering') ? 'selected' : '' ?>>Engineering</option>
                <option value="Arts" <?= ($student['course'] == 'Arts') ? 'selected' : '' ?>>Arts</option>
            </select>
            <input type="number" name="age" placeholder="Age" value="<?= $student['age'] ?>" required>
            <button type="submit" name="update">Update Student</button>
        </form>

        <a href="index.php" class="back-btn">Back to Student List</a>
    </div>
</body>
</html>

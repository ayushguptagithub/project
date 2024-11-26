<?php
include "conn.php";
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $age = $_POST['age'];

    $stmt = $conn->prepare("INSERT INTO students (name, email, course, age) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $course, $age);
    $stmt->execute();
    $stmt->close();
}

// Update Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $age = $_POST['age'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ?, age = ? WHERE id = ?");
    $stmt->bind_param("sssii", $name, $email, $course, $age, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete Student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id = $id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9 url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }
        header {
            /* text-align: center; */
            display:flex;
            justify-content:space-between;
            margin: 20px 0;
        }
        h1 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }
        a.logout {
            
            display: flex;
            align-items:center;
            color: #fff;
            background-color: #ff5722;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
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
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: #fff;
        }
        .action a{
            width: 100%;
        }
        .action-btn {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn {
            width: 100%;
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        button:hover {
            background-color: #0056b3;
        }
        /* Responsive design */
        @media screen and (max-width: 768px) {
            form, table {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Student Management System</h1>
            <a href="logout.php" class="logout">Logout</a>
        </header>

        <!-- Add Student Form -->
        <form method="POST">
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="email" name="email" placeholder="Student Email" required>
            <select name="course" required>
                <option value="Computer Science">Computer Science</option>
                <option value="Engineering">Engineering</option>
                <option value="Arts">Arts</option>
            </select>
            <input type="number" name="age" placeholder="Age" required>
            <button type="submit" name="add">Add Student</button>
        </form>

        <!-- Display Students -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM students");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['age']}</td>
                            <td>
                                <div class='action'>
                                    <form action='edit.php' method='GET'>
                                        <button type='submit' name='edit' value='{$row['id']}' class='action-btn'>Edit</button>
                                    </form>
                                    <a href='?delete={$row['id']}' class='delete-btn'>Delete</a>
                                </div>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Confirmation for Deletion
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                if (!confirm("Are you sure you want to delete this record?")) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

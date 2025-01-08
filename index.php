<?php
session_start();

// Check if a user is already logged in
if (isset($_SESSION["student_id"])) {
    header("Location: student_menu.php");
    exit();
} elseif (isset($_SESSION["lecturer_id"])) {
    header("Location: lecturer_menu.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user_type"])) {
        $userType = $_POST["user_type"];

        if ($userType == "student") {
            header("Location: student_index.php");
            exit();
        } elseif ($userType == "lecturer") {
            header("Location: lecturer_index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME TO FKI LEAVE MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="header">
        <h1>WELCOME TO FKI LEAVE MANAGEMENT SYSTEM</h1>
    </div>

    <div class="center-content">
        <h2>Please select your user type</h2>

        <form method="post" action="index.php">
            <button type="submit" name="user_type" value="student" class="large-button">Student</button>
            <button type="submit" name="user_type" value="lecturer" class="large-button">Lecturer</button>
        </form>
    </div>

    <footer>
        <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
    </footer>
</body>

</html>

<?php
session_start();

// Include your database configuration file
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);

    // Your SQL query to check user credentials
    $sql = "SELECT * FROM students WHERE matricNo = '$userName'";
    
    // Check if $conn is a valid mysqli object
    if ($conn instanceof mysqli) {
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // User found, check password
            $row = $result->fetch_assoc();
            if (password_verify($userPwd, $row["userPwd"])) {
                // Password is correct, set session variables
                $_SESSION["student_id"] = $row["student_id"];
                $_SESSION["userName"] = $row["matricNo"]; // Assuming matricNo is the username
                $_SESSION["img_path"] = $row["img_path"]; // Assuming you have an img_path field

                // Redirect to student_index.php
                header("Location: student_index.php");
                exit();
            } else {
                // Incorrect password
                echo "Incorrect password. Please try again.";
            }
        } else {
            // User not found
            echo "User not found. Please check your username.";
        }
    } else {
        // Connection is not valid
        echo "Database connection error.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

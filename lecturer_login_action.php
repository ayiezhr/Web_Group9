<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php'; // Autoload using Composer

use App\Config; // Assuming your config class is defined under the App\Config namespace

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if $conn is valid
    if (isset(Config::$conn) && Config::$conn instanceof mysqli) {
        $conn = Config::$conn;

        // Get user input and sanitize
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);

        // SQL query to check lecturer credentials
        $sql = "SELECT * FROM lecturers WHERE lecturerNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // User found, verify password
            $row = $result->fetch_assoc();
            if (password_verify($userPwd, $row["userPwd"])) {
                // Password is correct, set session variables
                $_SESSION["lecturer_id"] = $row["lecturer_id"];
                $_SESSION["userName"] = $row["lecturerNo"];
                $_SESSION["img_path"] = $row["img_path"];

                // Redirect to lecturer_index.php
                header("Location: lecturer_index.php");
                exit();
            } else {
                // Incorrect password
                echo "Incorrect password. Please try again.";
            }
        } else {
            // User not found
            echo "User not found. Please check your username.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Connection is not valid
        echo "Database connection error.";
    }
}

// Close the database connection
if (isset(Config::$conn) && Config::$conn instanceof mysqli) {
    Config::$conn->close();
}
?>

<?php
session_start();
include('config.php');

 // Retrieve form data
$matricNo = $_POST['matric_no'];
$rating = $_POST['rating'];
$feedback = $_POST['feedback'];
$suggestion = $_POST['suggestion'];

// For upload
$target_dir = "uploads/";
$uploadOk = 0;
$uploadFileName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database connection established in $conn variable
    // Connect to your database using appropriate credentials
    include("config.php"); // Include your database connection file

    // Insert data into the database
    $sql = "INSERT INTO studfeedback (matric_no, rating, feedback, suggestion, submission_date)
            VALUES ('$matricNo', '$rating', '$feedback', '$suggestion', CURRENT_TIMESTAMP)";

    if (mysqli_query($conn, $sql)) {
        echo "Feedback submitted successfully!<br>";
        echo '<a href="student_feedback.php">Back</a>';
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        echo '<a href="javascript:history.back()">Back</a>';
    }
}
    // Close the database connection
    mysqli_close($conn);
?>

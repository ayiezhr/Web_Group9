<?php
session_start();
include('config.php');

// Retrieve form data
$lecturerId = $_POST['lecturer_id']; // Update to match the form input name
$rating = $_POST['rating'];
$feedback = $_POST['feedback'];
$suggestion = $_POST['suggestion'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database connection established in $conn variable
    // Connect to your database using appropriate credentials
    include("config.php"); // Include your database connection file

    // Insert data into the database
    $sql = "INSERT INTO lectfeedback (lecturer_id, rating, feedback, suggestion, submission_date)
            VALUES ('$lecturerId', '$rating', '$feedback', '$suggestion', CURRENT_TIMESTAMP)";

    if (mysqli_query($conn, $sql)) {
        echo "Feedback submitted successfully!<br>";
        echo '<a href="lecturer_feedback.php">Back</a>'; // Update link accordingly
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        echo '<a href="javascript:history.back()">Back</a>';
    }
    // Close the database connection
    mysqli_close($conn);
}
?>

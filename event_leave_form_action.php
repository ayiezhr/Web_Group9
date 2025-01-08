<?php
session_start();
include("config.php");

// Variables
$sem = isset($_POST["sem"]) ? $_POST["sem"] : "";
$year = isset($_POST["year"]) ? $_POST["year"] : "";
$courseCode = isset($_POST["courseCode"]) ? trim($_POST["courseCode"]) : "";
$lecturerName = isset($_POST["lecturerName"]) ? trim($_POST["lecturerName"]) : "";
$reason = isset($_POST["reason"]) ? trim($_POST["reason"]) : "";
$exemptionletterPath = ""; 

// For upload
$targetDir = "uploads/";
$uploadOk = 1; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Medical Certificate Upload
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        $exemptionletterFile = $_FILES["fileToUpload"]["name"];
        $targetFileExemption = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $fileTypeExemption = strtolower(pathinfo($targetFileExemption, PATHINFO_EXTENSION));

        // Check file size <= 488.28KB or 500000 bytes
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "ERROR: Sorry, your file is too large. Try resizing your file.<br>";
            $uploadOk = 0;
        }

        // Allow only PDF files
        if ($fileTypeExemption != "pdf") {
            echo "ERROR: Sorry, only PDF files are allowed.<br>";
            $uploadOk = 0;
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFileExemption)) {
                $exemptionletterPath = $exemptionletterFile;
            } else {
                echo "Sorry, there was an error uploading your Medical Certificate.<br>";
                $uploadOk = 0;
            }
        }
    }

    // Get the lecturer_id from the form
    $lecturer_id = isset($_POST['lecturer_id']) ? $_POST['lecturer_id'] : 0;

    // Insert data into the sick_leave_form table
    $sql = "INSERT INTO event_leave_form (student_id, sem, year, courseCode, lecturer_id, reason, exemption_letter_path) 
            VALUES (" . $_SESSION["student_id"] . ", " . $sem . ", '" . $year . "', '" . $courseCode . "', '" . $lecturer_id . "', '" . $reason . "', '" . $exemptionletterPath . "')";

    // Perform the SQL query
    if ($uploadOk && mysqli_query($conn, $sql)) {
        echo "Event Leave form data saved successfully!<br>";
        echo '<a href="student_leave_form.php">Back</a>';
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        echo '<a href="javascript:history.back()">Back</a>';
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect back if the form is not submitted
    header("Location: student_leave_form.php");
    exit();
}
?>

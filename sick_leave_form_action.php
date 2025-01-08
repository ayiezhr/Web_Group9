<?php
session_start();
include("config.php");

// Variables
$sem = isset($_POST["sem"]) ? $_POST["sem"] : "";
$year = isset($_POST["year"]) ? $_POST["year"] : "";
$courseCode = isset($_POST["courseCode"]) ? trim($_POST["courseCode"]) : "";
$lecturerName = isset($_POST["lecturerName"]) ? trim($_POST["lecturerName"]) : "";
$reason = isset($_POST["reason"]) ? trim($_POST["reason"]) : "";
$medicalCertificatePath = ""; // This variable wasn't correctly assigned

// For upload
$targetDir = "uploads/";
$uploadOk = 1; // Initialize the variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Medical Certificate Upload
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        $medicalCertificateFile = $_FILES["fileToUpload"]["name"];
        $targetFileMedical = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $fileTypeMedical = strtolower(pathinfo($targetFileMedical, PATHINFO_EXTENSION));

        // Check file size <= 488.28KB or 500000 bytes
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "ERROR: Sorry, your file is too large. Try resizing your file.<br>";
            $uploadOk = 0;
        }

        // Allow only PDF files
        if ($fileTypeMedical != "pdf") {
            echo "ERROR: Sorry, only PDF files are allowed.<br>";
            $uploadOk = 0;
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFileMedical)) {
                $medicalCertificatePath = $medicalCertificateFile;
            } else {
                echo "Sorry, there was an error uploading your Medical Certificate.<br>";
                $uploadOk = 0;
            }
        }
    }

    // Get the lecturer_id from the form
    $lecturer_id = isset($_POST['lecturer_id']) ? $_POST['lecturer_id'] : 0;

    // Insert data into the sick_leave_form table
    $sql = "INSERT INTO sick_leave_form (student_id, sem, year, courseCode, lecturer_id, reason, medical_certificate_path) 
            VALUES (" . $_SESSION["student_id"] . ", " . $sem . ", '" . $year . "', '" . $courseCode . "', '" . $lecturer_id . "', '" . $reason . "', '" . $medicalCertificatePath . "')";

    // Perform the SQL query
    if ($uploadOk && mysqli_query($conn, $sql)) {
        echo "Sick Leave form data saved successfully!<br>";
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

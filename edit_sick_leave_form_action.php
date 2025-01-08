<?php
session_start();
include('config.php');


    $id = "";
    $sem = "";
    $year = "";
    $courseCode= "";
    $reason = "";
    $medicalCertificatePath = "";
    $status = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update data in the activities table
    $sql = "UPDATE activities 
            SET sem=?, year=?, courseCode=?, reason=?, medicalCertificatePath=?, status=?,
            WHERE sick_id=? AND student_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssi", $sem, $year, $courseCode, $reason, $student_ID, $_SESSION["lecturer_id"]);

    $status = mysqli_stmt_execute($stmt);

    if ($status) {
        // Activity updated successfully
        echo "Sick Leave Approved successfully!<br>";
        echo '<a href="my_activities.php">Back to Activities</a>';
    } else {
        // Failed to update activity
        echo "Failed to approve Sick Leave.<br>";
        echo '<a href="my_activities.php">Back to Activities</a>';
    }
}

mysqli_close($conn);
?>

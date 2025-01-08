<?php
session_start();
include_once 'config.php';

$lecturerId = $_SESSION['lecturer_id'];

if (isset($_POST['submit'])) {
    $username = $_POST["username"];
    $courseCode = $_POST["course_code"];
    $courseName = $_POST["courseName"];

    // Upload picture if available
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        // Target directory for the uploaded picture
        $target_dir = "lectprofile/";

        // Retrieve the old image path from the database
        $sqlSelect = "SELECT img_path FROM lectprofile WHERE lecturer_id = ?";
        $stmtSelect = mysqli_prepare($conn, $sqlSelect);
        mysqli_stmt_bind_param($stmtSelect, "i", $lecturerId);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $oldImgPath);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);

        // Check if the old image is the default image
        $isDefaultImage = $oldImgPath === 'photo.png';

        // If the old image is not the default image, delete it
        if (!$isDefaultImage && !empty($oldImgPath)) {
            $oldImagePath = "lectprofile/" . basename($oldImgPath);

            // Check if the file exists and it is a file (not a directory) before attempting to delete
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                if (unlink($oldImagePath)) {
                    echo "Old image file deleted successfully<br>";
                } else {
                    echo "Error deleting old image file: $oldImagePath<br>";
                }
            } else {
                echo "Old image file not found or it is a directory: $oldImagePath<br>";
            }
        }

        // File of the image/photo file
        $uploadfileName = basename($_FILES["fileToUpload"]["name"]);

        // Path of the image/photo file
        $target_file = $target_dir . $uploadfileName;

        // Variables to determine if image upload is OK
        $uploadOk = 1;

        // Get file type and check its format
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file already exists
        if (file_exists($target_file)) {
            echo "ERROR: Sorry, image file $uploadfileName already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "ERROR: Sorry, your file is too large. Try resizing your image.<br>";
            $uploadOk = 0;
        }

        // Allow only these file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // If uploadOk, then try adding to the database first
        if ($uploadOk) {
            $sql = "UPDATE lectprofile SET username = ?, course_code = ?, courseName = ?, img_path = ? WHERE lecturer_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $username, $courseCode, $courseName, $uploadfileName, $lecturerId);

            $status = update_DBTable($stmt, $conn);

            if ($status) {
                $_SESSION["img_path"] = $uploadfileName;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // Image file successfully uploaded
                    // Tell successful record
                    echo "Profile updated successfully!<br>";
                    echo '<a href="lecturer_profile.php">Back</a>';
                } else {
                    // There is an error while uploading the image
                    echo "Sorry, there was an error uploading your profile picture.<br>";
                    echo '<a href="javascript:history.back()">Back</a>';
                }
            } else {
                echo '<a href="javascript:history.back()">Back</a>';
            }
        } else {
            echo '<a href="javascript:history.back()">Back</a>';
        }
    }
    // If there is no image to be uploaded
    else {
        $sql = "UPDATE lectprofile SET username = ?, course_code = ?, courseName = ? WHERE lecturer_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $courseCode, $courseName, $lecturerId);

        $status = update_DBTable($stmt, $conn);

        if ($status) {
            echo "Profile updated successfully!<br>";
            echo '<a href="lecturer_profile.php">Back</a>';
        }
    }
} else {
    echo "Form not submitted.";
}

// Close db connection
mysqli_close($conn);

// Function to insert data into the database table
function update_DBTable($stmt, $conn)
{
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        echo "Error: " . mysqli_stmt_error($stmt) . "<br>";
        return false;
    }
}
?>

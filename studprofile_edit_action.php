<?php
session_start();
include_once 'config.php';

$id = $_SESSION['student_id'];

if (isset($_POST['submit'])) {
    // Validate inputs
    $inputs = validateInputs($_POST);
    if (!$inputs) {
        echo "Invalid inputs.";
        return;
    }

    // Handle file upload (if available)
    $uploadFileName = null;
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $uploadFileName = handleFileUpload($_FILES["fileToUpload"], $id, $conn);
    }

    // Update database
    $status = updateDatabase($inputs, $uploadFileName, $id, $conn);
    if ($status) {
        echo "Profile updated successfully!";
        echo '<a href="profile_student.php">Back</a>';
    } else {
        echo "Failed to update profile.";
        echo '<a href="javascript:history.back()">Back</a>';
    }
} else {
    echo "Form not submitted.";
}

mysqli_close($conn);

// Function to validate inputs
function validateInputs($data) {
    $username = $data['username'];
    $program = $data['program'];
    $mentor = $data['mentor'];
    $motto = $data['motto'];

    if (empty($username) || empty($program) || empty($mentor) || empty($motto)) {
        return false;
    }

    return ['username' => $username, 'program' => $program, 'mentor' => $mentor, 'motto' => $motto];
}

// Function to handle file upload
function handleFileUpload($file, $id, $conn) {
    $target_dir = "studprofile/";
    $uploadFileName = basename($file["name"]);
    $target_file = $target_dir . $uploadFileName;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Invalid file type.";
        return null;
    }

    if ($file["size"] > 5000000) {
        echo "File size too large.";
        return null;
    }

    // Delete old image
    deleteOldImage($id, $conn);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $uploadFileName;
    } else {
        echo "Failed to upload file.";
        return null;
    }
}

// Function to delete old image
function deleteOldImage($id, $conn) {
    $sql = "SELECT img_path FROM studprofile WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $oldImgPath);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($oldImgPath && $oldImgPath !== 'photo.png') {
        $oldImagePath = "studprofile/" . basename($oldImgPath);
        if (file_exists($oldImagePath) && is_file($oldImagePath)) {
            unlink($oldImagePath);
        }
    }
}

// Function to update the database
function updateDatabase($inputs, $uploadFileName, $id, $conn) {
    $sql = "UPDATE studprofile SET username = ?, program = ?, mentor = ?, motto = ?" .
           ($uploadFileName ? ", img_path = ?" : "") .
           " WHERE student_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if ($uploadFileName) {
        mysqli_stmt_bind_param($stmt, "ssissi", $inputs['username'], $inputs['program'], $inputs['mentor'], $inputs['motto'], $uploadFileName, $id);
    } else {
        mysqli_stmt_bind_param($stmt, "ssssi", $inputs['username'], $inputs['program'], $inputs['mentor'], $inputs['motto'], $id);
    }

    return mysqli_stmt_execute($stmt);
}
?>

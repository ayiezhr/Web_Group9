<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userMatric = mysqli_real_escape_string($conn, $_POST['lecturerNo']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['lectEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    // Validate password and confirmPwd
    if ($userPwd !== $confirmPwd) {
        die("Password and confirm password do not match.");
    }

    // Check if userEmail already exists
    $sqlCheckUser = "SELECT * FROM lecturers WHERE lectEmail='$userEmail' OR lecturerNo='$userMatric' LIMIT 1";
    $resultCheckUser = mysqli_query($conn, $sqlCheckUser);

    if (mysqli_num_rows($resultCheckUser) == 1) {
        echo "<p><b>Error:</b> lecturer exists, please register a new lecturer</p>";
    } else {
        // User does not exist, insert new user record, hash the password
        $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));
        $sqlInsertUser = "INSERT INTO lecturers (lecturerNo, lectEmail, userPwd) VALUES ('$userMatric', '$userEmail', '$pwdHash')";
        $insertOK = 0;

        if (mysqli_query($conn, $sqlInsertUser)) {
            echo "<p>New lecturer record created successfully.</p>";
            $insertOK = 1;

            // If registration is successful, get the last inserted student_id
            $lastInsertedId = mysqli_insert_id($conn);

            // Insert a new record into the studprofile table
           $sqlInsertProfile = "INSERT INTO lectprofile (lecturer_id, lecturerNo, lectEmail, username, course_code, courseName, img_path) 
                     VALUES ('$lastInsertedId', '$userMatric', '$userEmail', '', '', '', '')";




            if (mysqli_query($conn, $sqlInsertProfile)) {
                echo "<p>New lecturer profile record created successfully. Welcome <b>" . $userMatric . "</b></p>";
            } else {
                echo "Error: " . $sqlInsertProfile . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $sqlInsertUser . "<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<p><a href="lecturer_index.php"> | Login |</a></p>
</body>
</html>


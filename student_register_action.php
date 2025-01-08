<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userMatric = mysqli_real_escape_string($conn, $_POST['matricNo']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    // Validate password and confirmPwd
    if ($userPwd !== $confirmPwd) {
        die("Password and confirm password do not match.");
    }

    // Check if userEmail already exists
    $sqlCheckUser = "SELECT * FROM students WHERE studEmail='$userEmail' OR matricNo='$userMatric' LIMIT 1";
    $resultCheckUser = mysqli_query($conn, $sqlCheckUser);

    if (mysqli_num_rows($resultCheckUser) == 1) {
        echo "<p><b>Error:</b> Student exists, please register a new student</p>";
    } else {
        // User does not exist, insert new user record, hash the password
        $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));
        $sqlInsertUser = "INSERT INTO students (matricNo, studEmail, userPwd) VALUES ('$userMatric', '$userEmail', '$pwdHash')";
        $insertOK = 0;

        if (mysqli_query($conn, $sqlInsertUser)) {
            echo "<p>New student record created successfully.</p>";
            $insertOK = 1;

            // If registration is successful, get the last inserted student_id
            $lastInsertedId = mysqli_insert_id($conn);

            // Insert a new record into the studprofile table
            $sqlInsertProfile = "INSERT INTO studprofile (student_id, username, program, mentor, motto) 
                                 VALUES ('$lastInsertedId', '', '', '', '')";

            if (mysqli_query($conn, $sqlInsertProfile)) {
                echo "<p>New student profile record created successfully. Welcome <b>" . $userMatric . "</b></p>";
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
<p><a href="student_index.php"> | Login |</a></p>
</body>
</html>


<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>
</head>

<body>
    <div class="header">
        <h1>My Profile</h1>
    </div>

    <?php
    if (isset($_SESSION["lecturer_id"])) {
        include 'lecturer_logged_menu.php';
    } else {
        include 'lecturer_menu.php';
    }
    ?>

    <?php
    if (isset($_SESSION["lecturer_id"])) {
        $lecturerId = $_SESSION["lecturer_id"];
        $sql = "SELECT lecturers.*, lectprofile.* FROM lecturers
                INNER JOIN lectprofile ON lecturers.lecturer_id = lectprofile.lecturer_id
                WHERE lecturers.lecturer_id = '$lecturerId'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $userMatric = $row["lecturerNo"];
			$userEmail = $row["lectEmail"];
			$username = $row["username"];
			$courseCode = $row["course_code"];
			$courseName = $row["courseName"];
			$profile = $row["img_path"];

    ?>
            <div class="row">
                <div class="col-left">
                    <?php
                    if (!empty($profile)) {
                        echo '<img class="image" src="lectprofile/' . $profile . '">';
                    } else {
                        echo '<img class="image" src="img/photo.png">';
                    }
                    ?>
                </div>
                <div class="col-right">
                    <div style="text-align: right; padding-bottom:5px;">
                        <a href="lectprofile_edit.php">Edit</a>
                    </div>
                <table class="blue-white-table">
					<tr>
						<td class="blue-side">Name</td>
						<td class="white-side"><?= $username ?></td>
					</tr>
					<tr>
						<td class="blue-side">Lecturer No.</td>
						<td class="white-side"><?= $userMatric ?></td>
					</tr>
					<tr>
						<td class="blue-side">Email</td>
						<td class="white-side"><?= $userEmail ?></td>
					</tr>
					<tr>
						<td class="blue-side">Course Code</td>
						<td class="white-side"><?= $courseCode ?></td>
					</tr>
					<tr>
						<td class="blue-side">Course Name</td>
						<td class="white-side"><?= $courseName ?></td>
					</tr>
				</table>

                </div>
            </div>
        <?php
        } else {
            echo '<p>No user profile found.</p>';
        }
    } else {
        echo '<p>No lecturer is currently signed in.</p>';
    }
        ?>

        <footer>
            <p><footer>
		<p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
	</footer></p>
        </footer>
    </body>

</html>

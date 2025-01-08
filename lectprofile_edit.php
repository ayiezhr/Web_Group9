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

        function deleteProfilePicture() {
            if (confirm("Are you sure you want to delete your profile picture?")) {
               
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_profile_picture.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                       
                        location.reload();
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>My Profile</h1>
    </div>

    <?php 
    if(isset($_SESSION["lecturer_id"])){
        include 'lecturer_logged_menu.php';
    }
    else {
        include 'lecturer_menu.php';
    }
    ?>

    <?php
        $sql = "SELECT lecturers.*, lectprofile.* FROM lecturers 
                INNER JOIN lectprofile ON lecturers.lecturer_id = lectprofile.lecturer_id 
                WHERE lecturers.lecturer_id = '{$_SESSION["lecturer_id"]}'";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $matricNo = $row["lecturerNo"];
            $userEmail = $row["lectEmail"];
            $username = $row["username"];
            $courseCode = $row["course_code"];
            $courseName = $row["courseName"];
            $profile = $row["img_path"];
        }
    ?>

    <div class="row">
        <div class="col-left">
            <?php
                echo '<img class="image" src="lectprofile/' . $profile . '">';
            ?>
        </div>
        <div class="col-right">             
            <form id="profile" action="lectprofile_edit_action.php" method="post" enctype="multipart/form-data">
                <table id="profile_table" width="100%">
                    <tr>
                        <td colspan="2"> 
                            Upload your photo (optional):                           
                            Max size: 2MB<br>
                            <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png">
                        </td>
                    </tr>
                    <tr>
                        <td width="164">Lecturer No.</td>
                        <td><?=$matricNo?></td>
                    </tr>
                    <tr>
                        <td width="164">Email</td>
                        <td><?=$userEmail?></td>
                    </tr>
                    <tr>
                        <td width="164">Name</td>
                        <td><input type="text" name="username" size="20" value="<?=$username?>"></td>
                    </tr>                    
                    <tr>
                        <td width="164">Course Code</td>
                        <td><input type="text" name="course_code" size="20" value="<?=$courseCode?>"></td>
                    </tr>
                    <tr>
                        <td width="164">Course Name</td>
                        <td><input type="text" name="courseName" size="20" value="<?=$courseName?>"></td>
                    </tr>
                </table>
                <div style="text-align: right; padding-bottom:5px;">
                    <input type="submit" name="submit" value="Update"> <input type="reset" value="Reset">
                </div>
            </form>
        </div>
    </div>
    <footer>
		<p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
	</footer>
</body>
</html>

<?php
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
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
        // Use AJAX to send a request to the server to delete the profile picture
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_profile_picture.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Reload the page after successful deletion
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
    if(isset($_SESSION["UID"])){
        include 'student_logged_menu.php';
    }
    else {
        include 'student_menu.php';
    }
    ?>

    <?php
		$sql = "SELECT students.*, studprofile.* FROM students 
		INNER JOIN studprofile ON students.student_id = studprofile.student_id 
		WHERE students.student_id = '{$_SESSION["student_id"]}'";

		$result = mysqli_query($conn, $sql);

		if (!$result) {
			die("Query failed: " . mysqli_error($conn));
		}

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);

			$matricNo = $row["matricNo"];
			$userEmail = $row["studEmail"];
			$name = $row["username"];
			$program = $row["program"];
			$mentor = $row["mentor"];
			$motto = $row["motto"];
			$profile = $row["img_path"];
		}
	?>


    <div class="row">
        <div class="col-left">
            <?php
				echo '<img class="image" src="studprofile/' . $profile . '">';
            ?>
        </div>
        <div class="col-right">             
            <form id="profile" action="studprofile_edit_action.php" method="post" enctype="multipart/form-data">
                <table id="profile_table" width="100%">
                    <tr>
                        <td colspan="2"> 
                            Upload your photo (optional):                           
                            Max size: 2MB<br>
                            <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png">
                            
                        </td>
                    </tr>
                    <tr>
                        <td width="164">Matric No.</td>
                        <td><?=$matricNo?></td>
                    </tr>
                    <tr>
                        <td width="164">Email</td>
                        <td><?=$userEmail?></td>
                    </tr>
                    <tr>
                        <td width="164">Name</td>
                        <td><input type="text" name="username" size="20" value="<?=$name?>"></td>
                    </tr>                    
                    <tr>
                        <td width="164">Program</td>
                        <td><select size="1" name="program">
                        <option value="" <?php echo ($program == '') ? 'selected' : ''; ?> disabled >Select Program</option>   
                        <option <?php echo ($program == 'Software Engineering') ? 'selected' : ''; ?>>Software Engineering</option>
                        <option <?php echo ($program == 'Network Engineering') ? 'selected' : ''; ?>>Network Engineering</option>
                        <option <?php echo ($program == 'Data Science') ? 'selected' : ''; ?>>Data Science</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td width="164">Mentor Name</td>
                       <td><input type="text" name="mentor" size="20" value="<?=$mentor?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"> 
                            My Study Motto:                           
                            <textarea rows="2" name="motto" style="width:100%"><?=$motto?></textarea>
                        </td>
                    </tr>
                </table>
                <div style="text-align: right; padding-bottom:5px;">
                <input type="submit" name="submit" value="Update"> <input type="reset" value="Reset">
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9) - </p>
    </footer>
</body>
</html>

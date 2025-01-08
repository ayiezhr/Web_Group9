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
    if(isset($_SESSION["student_id"])){
        include 'student_logged_menu.php';
    }
    else {
        include 'student_menu.php';
    }
    ?>

	<?php
		if (isset($_SESSION["student_id"])) {
		$studentId = $_SESSION["student_id"];
		$sql = "SELECT students.*, studprofile.* FROM students 
				INNER JOIN studprofile ON students.student_id = studprofile.student_id 
				WHERE students.student_id = '$studentId'";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			die("Query failed: " . mysqli_error($conn));
		}

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$matricNo = $row["matricNo"];
			$userEmail = $row["studEmail"];
			$username = $row["username"];
			$program = $row["program"];
			$mentor = $row["mentor"];
			$motto = $row["motto"];
			$profile = $row["img_path"];
	?>
			
             <div class="row">
        <div class="col-left">
            <?php
            if (!empty($profile)) {
                echo '<img class="image" src="studprofile/' . $profile . '">';
            } else {
                echo '<img class="image" src="img/photo.png">';
            }
            ?>
        </div>
        <div class="col-right"> 
            <div style="text-align: right; padding-bottom:5px;">
                <a href="studprofile_edit.php">Edit</a>
            </div>  
			<table class="blue-white-table">
				<tr>
					<td class="blue-side">Name</td>
					<td class="white-side"><?=$username?></td>
				</tr>
				<tr>
					<td class="blue-side">Matric No.</td>
					<td class="white-side"><?=$matricNo?></td>
				</tr>
				<tr>
					<td class="blue-side">Email</td>
					<td class="white-side"><?=$userEmail?></td>
				</tr>
				<tr>
					<td class="blue-side">Program</td>
					<td class="white-side"><?=$program?></td>
				</tr>
				<tr>
					<td class="blue-side">Mentor Name</td>
					<td class="white-side"><?=$mentor?></td>
				</tr>
			</table>

            <p>My Study Motto</p>
            <table border="1" width="100%"  style="border-collapse: collapse">
                <tr">
                    <td>
                        <?php
                        if($motto==""){
                            echo "&nbsp;";
                        }
                        else{
                            echo $motto;
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
            <?php
        } else {
            echo '<p>No student profile found.</p>';
        }
    } else {
        echo '<p>No student is currently signed in.</p>';
    }
    ?>

    <footer>
        <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
    </footer>
</body>
</html>

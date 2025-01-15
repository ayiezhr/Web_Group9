<?php
session_start();
include "config.php";

// Function to retrieve sick leave applications based on search
function searchSickLeaveApplications($conn, $student_id, $searchTerm) {
    $sql = "SELECT * FROM sick_leave_form 
            WHERE student_id = $student_id 
            AND (sem LIKE '%$searchTerm%' OR year LIKE '%$searchTerm%' 
                OR courseCode LIKE '%$searchTerm%' OR reason LIKE '%$searchTerm%' 
                OR medical_certificate_path LIKE '%$searchTerm%' OR status LIKE '%$searchTerm%')";
    
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die(mysqli_error($conn));
    }

    return $result;
}

$student_id = $_SESSION["student_id"];
$searchTerm = isset($_POST["search"]) ? mysqli_real_escape_string($conn, $_POST["search"]) : "";

// Retrieve sick leave applications based on search
$sickLeaveApplications = searchSickLeaveApplications($conn, $student_id, $searchTerm);
?>

<!DOCTYPE html>
<html>

<head>
    <title>FKI Leave Management - Sick Leave Search Results</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
</head>

<body>
    <div class="header">
        <h1>Leave Application</h1>
    </div>

    <?php 
        if(isset($_SESSION["student_id"])){
            include 'student_logged_menu.php';
        } else {
            include 'student_menu.php';
        }
    ?>

    <h2>Sick Leave Search Results</h2>

    <div style="padding: 0 10px;">
        <table border="1" width="100%" id="projectable">
            <tr>
                <th>No</th>
                <th>Semester & Year</th>
                <th>Course Code</th>
                <th>Reason</th>
                <th>Medical Certificate</th>
                <th>Status</th>
            </tr>
            <?php
		define('TD_SEPARATOR', '</td><td>');
		
		if (mysqli_num_rows($sickLeaveApplications) > 0) {
		    $numrow = 1;
		    while ($row = mysqli_fetch_assoc($sickLeaveApplications)) {
		        echo "<tr>";
		        echo "<td>" . $numrow . TD_SEPARATOR . 
		             $row["sem"] . " " . $row["year"] . TD_SEPARATOR . 
		             $row["courseCode"] . TD_SEPARATOR . 
		             $row["reason"] . TD_SEPARATOR . 
		             $row["medical_certificate_path"] . TD_SEPARATOR . 
		             $row["status"] . 
		             "</td>";
		        echo "</tr>";
		        $numrow++;
		    }
		} else {
		    echo '<tr><td colspan="6">No sick leave applications found for the given search term</td></tr>';
		}
		?>
        </table>
    </div>

    <p></p>
	<footer>
		<p><footer>
		<p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
	</footer></p>
	</footer>

	<script>
	//for responsive sandwich menu
	function myFunction() {
		var x = document.getElementById("myTopnav");
		if (x.className === "topnav") {
			x.className += " responsive";
		} else {
			x.className = "topnav";
		}
	}

	function show_AddEntry(divId) {  
		var x = document.getElementById(divId);
		x.style.display = 'block';
		var firstField = x.querySelector('select');
		if (firstField) {
			firstField.focus();
		}
	}


	window.addEventListener('DOMContentLoaded', function() {
		adjustFooterPosition();

		window.addEventListener('resize', adjustFooterPosition);
	});


	</script>
</body>
</html>

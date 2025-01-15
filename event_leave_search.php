<?php
session_start();
include_once "config.php";

function searchEventLeaveApplications($conn, $student_id, $searchTerm) {
    $sql = "SELECT * FROM event_leave_form
            WHERE student_id = $student_id
            AND (sem LIKE '%$searchTerm%' OR year LIKE '%$searchTerm%'
                OR courseCode LIKE '%$searchTerm%' OR reason LIKE '%$searchTerm%'
                OR exemption_letter_path LIKE '%$searchTerm%' OR status LIKE '%$searchTerm%')";
    
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die(mysqli_error($conn));
    }

    return $result;
}

$student_id = $_SESSION["student_id"];
$searchTerm = isset($_POST["search"]) ? mysqli_real_escape_string($conn, $_POST["search"]) : "";

$eventLeaveApplications = searchEventLeaveApplications($conn, $student_id, $searchTerm);
?>

<!DOCTYPE html>
<html>

<head>
    <title>FKI Leave Management - Event Leave Search Results</title>
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

    <h2>Event Leave Search Results</h2>

    <div style="padding: 0 10px;">
        <table border="1" width="100%" id="projectable">
            <tr>
                <th>No</th>
                <th>Semester & Year</th>
                <th>Course Code</th>
                <th>Reason</th>
                <th>Exemption Letter Path</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($eventLeaveApplications) > 0) {
                $numrow = 1;
                while ($row = mysqli_fetch_assoc($eventLeaveApplications)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td><td>" . $row["sem"] . " " . $row["year"] . "</td><td>" . $row["courseCode"] .
                        "</td><td>" . $row["reason"] . "</td><td>" . $row["exemption_letter_path"] . "</td><td>" . $row["status"] .
                        "</td>";
                    echo "</tr>";
                    $numrow++;
                }
            } else {
                echo '<tr><td colspan="6">No event leave applications found for the given search term</td></tr>';
            }
            ?>
        </table>
    </div>

    <p></p>
	<footer>
		<p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
	</footer>
	
	<script>
	
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

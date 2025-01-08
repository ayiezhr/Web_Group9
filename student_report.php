<?php
session_start();
include("config.php");

// Function to retrieve sick leave applications
function getSickLeaveApplications($conn, $student_id) {
    $sql = "SELECT * FROM sick_leave_form WHERE student_id = $student_id";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die(mysqli_error($conn));
    }

    return $result;
}

$student_id = isset($_SESSION["student_id"]) ? $_SESSION["student_id"] : null;

// Retrieve sick leave applications
$sickLeaveApplications = $student_id ? getSickLeaveApplications($conn, $student_id) : null;

// Function to retrieve event leave applications
function getEventLeaveApplications($conn, $student_id) {
    $sql = "SELECT * FROM event_leave_form WHERE student_id = $student_id";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die(mysqli_error($conn));
    }

    return $result;
}

// Retrieve event leave applications
$eventLeaveApplications = $student_id ? getEventLeaveApplications($conn, $student_id) : null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>FKI Leave Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="header">
        <h1>Leave Report</h1>
    </div>

    <?php
    if (isset($_SESSION["student_id"])) {
        include 'student_logged_menu.php';
    } else {
        include 'student_menu.php';
    }
    ?>

    <?php if ($student_id) : ?>
        <h2>List of Leave Application</h2>
        <h3>List of Sick Leave</h3>

        <div style="padding:0 10px;">
            <?php if ($sickLeaveApplications) : ?>
                <div style="text-align: right; padding: 10px;">
                    <form action="sick_leave_search.php" method="post">
                        <input type="text" placeholder="Search.." name="search">
                        <input type="submit" value="Search">
                    </form>
                </div>
				
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
                    if (mysqli_num_rows($sickLeaveApplications) > 0) {
                        $numrow = 1;
                        while ($row = mysqli_fetch_assoc($sickLeaveApplications)) {
                            echo "<tr>";
                            echo "<td>" . $numrow . "</td><td>" . $row["sem"] . " " . $row["year"] . "</td><td>" . $row["courseCode"] .
                                "</td><td>" . $row["reason"] . "</td><td>" . $row["medical_certificate_path"] . "</td><td>" . $row["status"] .
                                "</td>";
                            echo "</tr>";
                            $numrow++;
                        }
                    } else {
                        echo '<tr><td colspan="7">No sick leave applications found</td></tr>';
                    }
                    ?>
                </table>
            <?php else : ?>
                <p>No sick leave applications found.</p>
            <?php endif; ?>
        </div>

        <br><h3>List of Event Leave</h3>

        <div style="padding:0 10px;">
            <?php if ($eventLeaveApplications) : ?>
                <div style="text-align: right; padding: 10px;">
                    <form action="event_leave_search.php" method="post">
                        <input type="text" placeholder="Search.." name="search">
                        <input type="submit" value="Search">
                    </form>
                </div>

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
                        echo '<tr><td colspan="7">No event leave applications found</td></tr>';
                    }
                    ?>
                </table>
            <?php else : ?>
                <p>No event leave applications found.</p>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <p>No student is currently signed in.</p>
    <?php endif; ?>

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

        window.addEventListener('DOMContentLoaded', function () {
            adjustFooterPosition();

            window.addEventListener('resize', adjustFooterPosition);
        });
    </script>
</body>

</html>

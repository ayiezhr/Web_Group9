<?php
session_start();
include("config.php");
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
        <h1>Leave Approval</h1>
    </div>

    <nav>
         <?php
			if (isset($_SESSION["lecturer_id"])) {
				include 'lecturer_logged_menu.php';

			
				$lecturerId = $_SESSION["lecturer_id"];
				$sql = "SELECT * FROM lecturers WHERE lecturer_id = '$lecturerId'";
				$result = mysqli_query($conn, $sql);

				if (!$result) {
					die("Query failed: " . mysqli_error($conn));
				}

				if (mysqli_num_rows($result) > 0) {
					
				} else {
					
					echo '<p>No matching lecturer found.</p>';
					
				}
			} else {
				include 'lecturer_menu.php';
			
				echo '<p>No lecturer is currently signed in.</p>';
			
			}
			?>

    </nav>

    <?php if (isset($_SESSION["lecturer_id"])) : ?>
        <h2>List of Sick Leave</h2>

        <div style="padding: 0 10px;">
            <div style="text-align: right; padding: 10px;">
                </form>
            </div>
            <table border="1" width="100%" id="projectable">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Sem/year</th>
                    <th width="20%">Course Code</th>
                    <th width="25%">reason</th>
                    <th width="30%">Medical Certificate Path</th>
                    <th width="30%">Status</th>
                    <th width="10%">Approval</th>
                </tr>
                <?php
                $sql = "SELECT * FROM sick_leave_form WHERE lecturer_id = " . $_SESSION["lecturer_id"];
                $result = mysqli_query($conn, $sql);

                if ($result === false) {
                    // Handle query error
                    die(mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    $numrow = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $numrow . "</td><td>" . $row["sem"] . " " . $row["year"] . "</td><td>" . $row["courseCode"] .
                            "</td><td>" . $row["reason"] . "</td><td>" . $row["medical_certificate_path"] .  "</td><td>" . $row["status"] . "</td>";
                        echo '<td> <a href="edit_sick_leave_form.php?id=' . $row["sick_id"] . '">Edit</a>';
                        echo "</tr>" . "\n\t\t";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6">0 results</td></tr>';
                }

                ?>
            </table>
        </div>

        <h2>List of Event Leave</h2>

        <div style="padding: 0 10px;">
            <div style="text-align: right; padding: 10px;">
                </form>
            </div>
            <table border="1" width="100%" id="projectable">
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Sem/Year</th>
                    <th width="20%">Course Code</th>
                    <th width="25%">reason</th>
                    <th width="30%">Exemption Letter Path</th>
                    <th width="30%">Status</th>
                    <th width="10%">Approval</th>
                </tr>
                <?php
                $sql = "SELECT * FROM event_leave_form WHERE lecturer_id = " . $_SESSION["lecturer_id"];
                $result = mysqli_query($conn, $sql);

                if ($result === false) {
                  
                    die(mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    $numrow = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $numrow . "</td><td>" . $row["sem"] . " " . $row["year"] . "</td><td>" . $row["courseCode"] .
                            "</td><td>" . $row["reason"] . "</td><td>" . $row["exemption_letter_path"] .  "</td><td>" . $row["status"] . "</td>";
                        echo '<td> <a href="edit_event_leave_form.php?id=' . $row["event_id"] . '">Edit</a>';
                        echo "</tr>" . "\n\t\t";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6">0 results</td></tr>';
                }

                ?>
            </table>
        </div>
    <?php endif; ?>

    <p></p>
    <footer>
        <p><footer>
            <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
        </footer></p>
    </footer>
</body>

</html>

<?php
session_start();
include "config.php";
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
    <h1>Feedback</h1>
</div>

<nav>
    <?php
    if (isset($_SESSION["lecturer_id"])) {
        include 'lecturer_logged_menu.php';

        // Check if a lecturer is logged in
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
                $lecturerId = $row["lecturer_id"];

                if (isset($row["rating"])) {
                    $rating = $row["rating"];
                } else {
                    $rating = ''; // Set a default value if the key doesn't exist
                }

                // Similarly, do the same for 'feedback' and 'suggestion'
                if (isset($row["feedback"])) {
                    $feedback = $row["feedback"];
                } else {
                    $feedback = '';
                }

                if (isset($row["suggestion"])) {
                    $suggestion = $row["suggestion"];
                } else {
                    $suggestion = '';
                }
            } else {
                // Redirect to login if no lecturer profile is found
                header("Location: lecturer_index.php");
                exit();
            }
        } else {
            // Redirect to login if no lecturer is logged in
            header("Location: lecturer_index.php");
            exit();
        }
    } else {
        include 'lecturer_menu.php';
        echo '<p>No lecturer is currently signed in.</p>';
        // You can customize this message further if needed
    }
    ?>
</nav>

<?php if (isset($_SESSION["lecturer_id"])) : ?>
    <h2 align="center"><b>Lecturer Feedback</b></h2>
    <nav>
        <h3 align="left">Add Feedback</h3>
        <p align="left">Required field with mark*</p>

        <form method="POST" action="lecturer_feedback_action.php">
           
           <table class="blue-white-table" width="500px">
					<tr>
						<td class="blue-side">Lecturer ID*:</td>
						<td class="white-side"><input type="text" name="lecturer_id" size="" value="<?= $lecturerId ?>" readonly><br></td>
					</tr>

					<tr>
						<td class="blue-side">Rating*</td>
						<td class="white-side">
							<input type="radio" name="rating" value="1" <?= $rating == 1 ? 'checked' : '' ?>>1
							<input type="radio" name="rating" value="2" <?= $rating == 2 ? 'checked' : '' ?>>2
							<input type="radio" name="rating" value="3" <?= $rating == 3 ? 'checked' : '' ?>>3
							<input type="radio" name="rating" value="4" <?= $rating == 4 ? 'checked' : '' ?>>4
							<input type="radio" name="rating" value="5" <?= $rating == 5 ? 'checked' : '' ?>>5
						</td>
					</tr>

					<tr>
						<td class="blue-side">Feedback*:</td>
						<td class="white-side"><p><textarea rows="4" name="feedback" cols="20"><?= $feedback ?></textarea></p></td>
					</tr>

					<tr>
						<td class="blue-side">Suggestion*:</td>
						<td class="white-side"><p><textarea rows="4" name="suggestion" cols="20"><?= $suggestion ?></textarea></p></td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td class="white-side smaller-row"><p><input type="submit" value="Submit" name="B1"></p></td>
					</tr>
				</table>

        </form>
    </nav>
<?php endif; ?>

<footer>
    <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
</footer>
</body>
</html>

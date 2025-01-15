<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php'; // Autoload using Composer

use App\Config;

// Check if the user is logged in as a lecturer
if (!isset($_SESSION["lecturer_id"])) {
    header("location:index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID and new status from the form
    $id = $_POST["id"];
    $newStatus = $_POST["newStatus"];

    // Update the status in the database
    $sql = "UPDATE sick_leave_form SET status = '$newStatus' WHERE lecturer_id = " . $_SESSION["lecturer_id"] . " AND sick_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Handle query error
        die("Error updating status: " . mysqli_error($conn));
    }

    echo "Status updated successfully!<br>";
    echo '<a href="lecturer_leave_approval.php">Back</a>';

    // Close the database connection
    mysqli_close($conn);
} else {
    // Check if the ID is provided in the query string
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        // Retrieve the sick leave entry from the database
        $sql = "SELECT * FROM sick_leave_form WHERE lecturer_id = " . $_SESSION["lecturer_id"] . " AND sick_id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            // Handle query error
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            ?>

            <!DOCTYPE html>
            <html>

            <head>
                <title>Edit Sick Leave Status</title>
                <link rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </head>

            <body>
                <div class="header">
                    <h1>Edit Sick Leave Status</h1>
                </div>

                <?php include 'lecturer_logged_menu.php'; ?>

                <div style="padding: 20px; text-align: center;">
                    <form method="post" action="edit_sick_leave_form.php">
                        <input type="hidden" name="id" value="<?php echo $row['sick_id']; ?>">
                        <label for="newStatus" style="font-size: 16px;">New Status:</label>
                        <select name="newStatus" style="font-size: 16px; padding: 5px;">
                            <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                            <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                        <br>
                        <input type="submit" value="Update Status" style="font-size: 16px; padding: 8px;">
                    </form>
                </div>

                <footer>
                    <p>Copyright (c) 2024 - FKI Leave Management System (GROUP 9)</p>
                </footer>
            </body>

            </html>

            <?php
        } else {
            echo "Invalid sick leave ID or you don't have permission to access this entry.<br>";
        }
    } else {
        echo "Sick leave ID not provided.<br>";
    }
}
?>

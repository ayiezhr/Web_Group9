<?php
session_start();
$_SESSION = array();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or any other desired page
header("Location: index.php");
exit();
?>


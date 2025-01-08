<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="topnav" id="myTopnav">
    <a href="lecturer_index.php" class="<?= ($current_page === 'lecturer_index.php' ? 'active' : '') ?>">Home</a>
    <a href="lecturer_profile.php" class="<?= ($current_page === 'lecturer_profile.php' ? 'active' : '') ?>">Profile</a>
    <a href="lecturer_leave_approval.php" class="<?= ($current_page === 'lecturer_leave_approval.php' ? 'active' : '') ?>">Leave Approval</a>
	<a href="lecturer_feedback.php" class="<?= ($current_page === 'lecturer_feedback.php' ? 'active' : '') ?>">Feedback</a>
    <a href="lecturer_logout.php">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</nav>

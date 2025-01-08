<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page file name
?>

<nav class="topnav" id="myTopnav">
     <a href="lecturer_index.php" class="<?= ($current_page === 'lecturer_index.php' ? 'active' : '') ?>">Home</a>
    <a href="lecturer_profile.php" class="<?= ($current_page === 'lecturer_profile.php' ? 'active' : '') ?>">Profile</a>
    <a href="lecturer_leave_approval.php" class="<?= ($current_page === 'lecturer_leave_approval.php' ? 'active' : '') ?>">Leave Approval</a>
	<a href="lecturer_feedback.php" class="<?= ($current_page === 'lecturer_feedback.php' ? 'active' : '') ?>">Feedback</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    
    <?php if (isset($_SESSION["lecturer_id"])) : ?>
        <a href="lecturer_logout.php" class="<?= ($current_page === 'lecturer_logout.php' ? 'active' : '') ?>">Logout</a>
    <?php endif; ?>
    
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
	
	 <a href="index.php" class="back-button">Back</a>
</nav>

<?php
$current_page = basename($_SERVER['PHP_SELF']); 

?>
<nav class="topnav" id="myTopnav">
    <a href="student_index.php" class="<?= ($current_page === 'student_index.php' ? 'active' : '') ?>">Home</a>
    <a href="profile_student.php" class="<?= ($current_page === 'profile_student.php' ? 'active' : '') ?>">Profile</a>
    <a href="student_leave_form.php" class="<?= ($current_page === 'student_leave_form.php' ? 'active' : '') ?>">Leave Form</a>
    <a href="student_report.php" class="<?= ($current_page === 'student_report.php' ? 'active' : '') ?>">Report</a>
	<a href="student_feedback.php" class="<?= ($current_page === 'student_feedback.php' ? 'active' : '') ?>">Feedback</a>
    <a href="student_logout.php">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</nav>

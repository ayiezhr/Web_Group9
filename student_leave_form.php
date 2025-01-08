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
        <h1>Leave Form</h1>
    </div>

    <?php
    if (isset($_SESSION["student_id"])) {
        include 'student_logged_menu.php';
    } else {
        include 'student_menu.php';
    }
    ?>
  
    <?php if (isset($_SESSION["student_id"])) : ?>

        <h2>Sick Leave Application</h2>

        <div style="padding:0 10px;">
            <button onclick="show_AddEntry('sickLeaveDiv')">Apply Sick Leave</button>

            <div style="display:none;" id="sickLeaveDiv">
                <h3 align="left">Add Sick Leave Request</h3>
                <p align="left">Required field with mark*</p>

                <form method="POST" action="sick_leave_form_action.php" enctype="multipart/form-data" id="myForm">
                 <table class="blue-white-table">
					<tr>
						<td class="blue-side">Semester*</td>
						<td class="white-side" width="1px">:</td>
						<td class="white-side">
							<select size="1" id="sem" name="sem" required>                        
								<option value="">&nbsp;</option>
								<option value="1">1</option>;                           
								<option value="2">2</option>;                        
							</select>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Year*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="year" size="9" pattern="20\d{2}/20\d{2}" title="Please enter a valid year in the format '20XX/20XX'" required>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Course Code*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="courseCode" size="10" required>                                    
						</td>
					</tr>
					<tr>
						<td class="blue-side">Lecturer ID*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="lecturer_id" size="10" required>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Reason</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<textarea rows="4" name="reason" cols="20"></textarea>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Please upload the exemption letter in PDF*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							Max size: 20MB<br>
							<input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf, .docx">
						</td>
					</tr>
					<tr>
						<td class="blue-side" colspan="3" align="right"> 
							<input type="submit" value="Submit" name="B1">                
							<input type="reset" value="Reset" name="B2">
						</td>
					</tr>
				</table>
			</form>
		</div>
      </div>

        <h2>Event Leave Application</h2>

        <div style="padding:0 10px;">
            <button onclick="show_AddEntry('eventLeaveDiv')">Apply Event Leave</button>

            <div style="display:none;" id="eventLeaveDiv">
                <h3 align="left">Add Event Leave Request</h3>
                <p align="left">Required field with mark*</p>

                <form method="POST" action="event_leave_form_action.php" enctype="multipart/form-data" id="myForm">
                 <table class="blue-white-table">
					<tr>
						<td class="blue-side">Semester*</td>
						<td class="white-side" width="1px">:</td>
						<td class="white-side">
							<select size="1" id="sem" name="sem" required>                        
								<option value="">&nbsp;</option>
								<option value="1">1</option>;                           
								<option value="2">2</option>;                        
							</select>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Year*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="year" size="9" pattern="20\d{2}/20\d{2}" title="Please enter a valid year in the format '20XX/20XX'" required>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Course Code*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="courseCode" size="10" required>                                    
						</td>
					</tr>
					<tr>
						<td class="blue-side">Lecturer ID*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<input type="text" name="lecturer_id" size="10" required>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Reason</td>
						<td class="white-side">:</td>
						<td class="white-side">
							<textarea rows="4" name="reason" cols="20"></textarea>
						</td>
					</tr>
					<tr>
						<td class="blue-side">Please upload the exemption letter in PDF*</td>
						<td class="white-side">:</td>
						<td class="white-side">
							Max size: 20MB<br>
							<input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf, .docx">
						</td>
					</tr>
					<tr>
						<td class="blue-side" colspan="3" align="right"> 
							<input type="submit" value="Submit" name="B1">                
							<input type="reset" value="Reset" name="B2">
						</td>
					</tr>
				</table>
                </form>
            </div>
        </div>
        <p></p>

    <?php else : ?>
        <p>No student is currently signed in.</p>
    <?php endif; ?>
	
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

<?php

		session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}

$sessionid = $_SESSION['fr_person_id'];
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$idError = null;
		$instructorError = null;
		
		// keep track post values
		$id = $_POST['course_id'];
		$instructor = $_POST['instructor_id'];
		
		
		// insert data
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO registration (course_id,instructor_id) SELECT courses.course_id, instructors.instructor_id FROM courses, instructors WHERE courses.course_id = ? AND instructors.instructor_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$instructor));			
			Database::disconnect();
			header("Location: registration.php");

	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row page-header">
		    			<h1>Register for a Class</h1>
		    		</div>
    		
	    			<form class="form-horizontal" action="register.php" method="post">

					<div class="col-lg-4">
                    <select class="form-control" id="select" name="course_id">
					  <?php
						$pdo = Database::connect();
						$sql = 'SELECT * from courses ORDER BY course_id DESC';
						foreach ($pdo->query($sql) as $row) {
								echo '<option value="' . $row['course_id'] . '">' . $row['course_id'] . '</option>';
						}
						Database::disconnect();
						?>
					</select>
                    <select class="form-control" id="select" name="instructor_id">
					  <?php
						$pdo = Database::connect();
						$sql = 'SELECT * from instructors ORDER BY instructor_id DESC';
						foreach ($pdo->query($sql) as $row) {
								echo '<option value="' . $row['instructor_id'] . '">' . $row['last_name'] . '</option>';
						}
						Database::disconnect();
						?>
					</select>
                      </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Register Course</button>
						  <a class="btn" href="registration.php">Back</a>
						</div>
                    </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

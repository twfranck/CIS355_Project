<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$idError = null;
		$instructorError = null;
		
		// keep track post values
		$id = $_POST['course_id'];
		$instructor = $_POST['instructor_id'];
		
		// validate input
		$valid = true;
		if (empty($id)) {
			$idError = 'Please enter an ID';
			$valid = false;
		}
		
		if (empty($instructor)) {
			$instructorError = 'Please enter an instructor ID';
			$valid = false;
		} 
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO registration (course_id,instructor_id) SELECT courses.course_id, instructors.instructor_id FROM courses, instructors WHERE courses.course_id = ? AND instructors.last_name = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$instructor));
			Database::disconnect();
			header("Location: registration.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Register for a Class</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="register.php" method="post">
					  <div class="control-group <?php echo !empty($idError)?'error':'';?>">
					    <label class="control-label">Course ID</label>
					    <div class="controls">
					      	<input name="course_id" type="text"  placeholder="CID" value="<?php echo !empty($id)?$id:'';?>">
					      	<?php if (!empty($idError)): ?>
					      		<span class="help-inline"><?php echo $idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($instructorError)?'error':'';?>">
					    <label class="control-label">Instructor ID</label>
					    <div class="controls">
					      	<input name="instructor_id" type="text"  placeholder="Name" value="<?php echo !empty($instructor)?$instructor:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $instructorError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Register Course</button>
						  <a class="btn" href="registration.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
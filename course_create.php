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
		$nameError = null;
		$descriptionError = null;
		$instructorError= null;
		
		// keep track post values
		$id = $_POST['course_id'];
		$name = $_POST['course_name'];
		$description = $_POST['course_description'];
		$instructor = $_POST['course_instructor'];
		
		// validate input
		$valid = true;
		if (empty($id)) {
			$idError = 'Please enter an ID';
			$valid = false;
		}
		
		if (empty($name)) {
			$nameError = 'Please enter a course name';
			$valid = false;
		} 
		
		if (empty($description)) {
			$descriptionError = 'Please enter a description';
			$valid = false;
		}
		
		if (empty($instructor)) {
			$instructorErrorError = 'Please enter an instructor';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO courses (course_id,course_name,course_description, course_instructor) values(?, ?, ?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$name,$description,$instructor));
			Database::disconnect();
			header("Location: courses.php");
		}
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
		    			<h1>Create a Class</h1>
		    		</div>
    		
	    			<form class="form-horizontal" action="course_create.php" method="post">
					<div class="col-lg-4">
					  <div class="control-group <?php echo !empty($idError)?'error':'';?>">
					    <label class="control-label">ID</label>
					    <div class="controls">
					      	<input class="form-control" name="course_id" type="text"  placeholder="ID" id="inputDefault" value="<?php echo !empty($id)?$id:'';?>">
					      	<?php if (!empty($idError)): ?>
					      		<span class="help-inline"><?php echo $idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Course Name</label>
					    <div class="controls">
					      	<input class="form-control" name="course_name" type="text"  placeholder="Name" id="inputDefault" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Course Description</label>
					    <div class="controls">
					      	<input class="form-control" name="course_description" type="text"  placeholder="Description" id="inputDefault" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($instructorError)?'error':'';?>">
					    <label class="control-label">Instructor's Last Name</label>
					    <div class="controls">
					      	<input class="form-control" name="course_instructor" type="text"  placeholder="Instructor" id="inputDefault" value="<?php echo !empty($instructor)?$instructor:'';?>">
					      	<?php if (!empty($instructorError)): ?>
					      		<span class="help-inline"><?php echo $instructorError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                     </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create Course</button>
						  <a class="btn" href="courses.php">Back</a>
						</div>
                      </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

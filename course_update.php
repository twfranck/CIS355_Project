<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['course_id'])) {
		$id = $_REQUEST['course_id'];
	}
	
	if ( null==$id ) {
		header("Location: courses.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$idError = null;
		$nameError = null;
		$descriptionError = null;
		
		// keep track post values
		$id = $_POST['course_id'];
		$name = $_POST['course_name'];
		$description = $_POST['course_description'];
		
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE courses  set course_id = ?, course_name = ?, course_description =? WHERE course_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$name,$description,$id));
			Database::disconnect();
			header("Location: courses.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM courses where course_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$id = $data['course_id'];
		$name = $data['course_name'];
		$description = $data['course_description'];
		Database::disconnect();
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
		    			<h3>Update Course Information</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="course_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($idError)?'error':'';?>">
					    <label class="control-label">Course ID</label>
					    <div class="controls">
					      	<input name="course_id" type="text"  placeholder="ID" value="<?php echo !empty($id)?$id:'';?>">
					      	<?php if (!empty($idError)): ?>
					      		<span class="help-inline"><?php echo $idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Course Name</label>
					    <div class="controls">
					      	<input name="course_name" type="text" placeholder="First" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="course_description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="courses.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
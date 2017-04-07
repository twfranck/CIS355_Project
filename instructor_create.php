<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$idError = null;
		$fNameError = null;
		$lNameError = null;
		
		// keep track post values
		$id = $_POST['instructor_id'];
		$fName = $_POST['first_name'];
		$lName = $_POST['last_name'];
		
		// validate input
		$valid = true;
		if (empty($id)) {
			$idError = 'Please enter an ID';
			$valid = false;
		}
		
		if (empty($fName)) {
			$fNameError = 'Please enter a first name';
			$valid = false;
		} 
		
		if (empty($lName)) {
			$lNameError = 'Please enter a last name';
			$valid = false;
		}
		
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO instructors (instructor_id,first_name,last_name) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$fName,$lName));
			Database::disconnect();
			header("Location: instructors.php");
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
		    			<h3>Add an Instructor</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="instructor_create.php" method="post">
					  <div class="control-group <?php echo !empty($idError)?'error':'';?>">
					    <label class="control-label">ID</label>
					    <div class="controls">
					      	<input name="instructor_id" type="text"  placeholder="ID" value="<?php echo !empty($id)?$id:'';?>">
					      	<?php if (!empty($idError)): ?>
					      		<span class="help-inline"><?php echo $idError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($fNameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="first_name" type="text"  placeholder="First" value="<?php echo !empty($fName)?$fName:'';?>">
					      	<?php if (!empty($fNameError)): ?>
					      		<span class="help-inline"><?php echo $fNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($lNameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="last_name" type="text"  placeholder="Last" value="<?php echo !empty($lName)?$lName:'';?>">
					      	<?php if (!empty($lNameError)): ?>
					      		<span class="help-inline"><?php echo $lNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Add Instructor</button>
						  <a class="btn" href="instructors.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['instructor_id'])) {
		$id = $_REQUEST['instructor_id'];
	}
	
	if ( null==$id ) {
		header("Location: instructors.php");
	}
	
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE instructors  set instructor_id = ?, first_name = ?, last_name =? WHERE instructor_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$fName,$lName,$id));
			Database::disconnect();
			header("Location: instructors.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM instructors where instructor_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$id = $data['instructor_id'];
		$fName = $data['first_name'];
		$lName = $data['last_name'];
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
		    			<h3>Update Instructor Information</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="instructor_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($idError)?'error':'';?>">
					    <label class="control-label">Instructor ID</label>
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
					      	<input name="first_name" type="text" placeholder="First" value="<?php echo !empty($fName)?$fName:'';?>">
					      	<?php if (!empty($fNameError)): ?>
					      		<span class="help-inline"><?php echo $fNameError;?></span>
					      	<?php endif;?>
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
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="instructors.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
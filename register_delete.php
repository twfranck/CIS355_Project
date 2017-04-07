<?php 
	require 'database.php';
	$id = null;
	
	if ( !empty($_GET['course_id'])) {
		$id = $_REQUEST['course_id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['course_id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM registration  WHERE course_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: registration.php");
		
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
		    			<h3>Drop Course</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="register_delete.php" method="post">
	    			  <input type="hidden" name="course_id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure you want to drop this course?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="registration.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
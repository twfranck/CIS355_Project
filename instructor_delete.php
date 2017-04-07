<?php 
	require 'database.php';
	$id = 0;
	
	if ( !empty($_GET['instructor_id'])) {
		$id = $_REQUEST['instructor_id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['instructor_id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM instructors  WHERE instructor_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: instructors.php");
		
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
		    			<h3>Delete an Instructor</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="instructor_delete.php" method="post">
	    			  <input type="hidden" name="instructor_id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure you want to delete this instructor?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="instructors.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
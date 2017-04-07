<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['instructor_id'])) {
		$id = $_REQUEST['instructor_id'];
	}
	
	if ( null==$id ) {
		header("Location: instructors.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM instructors where instructor_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    			<h3>Instructor Information</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">ID</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['instructor_id'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['first_name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['last_name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="form-actions">
						<a class="btn" href="instructors.php">Back</a>
					  </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
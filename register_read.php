<?php

		session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}

$sessionid = $_SESSION['fr_person_id'];

	require 'database.php';
	$id = null;
	if ( !empty($_GET['course_id'])) {
		$id = $_REQUEST['course_id'];
	}
	
	if ( null==$id ) {
		header("Location: registration.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT registration.course_id AS course_id, courses.course_name AS course_name, instructors.last_name AS instructor FROM registration JOIN courses ON registration.course_id = courses.course_id JOIN instructors ON registration.instructor_id = instructors.instructor_id WHERE courses.course_id = ?";
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
    				<div class="row page-header">
		    			<h1>Course Information</h1>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <h4><u>ID</u></h4>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['course_id'];?>
						    </label>
					    </div>
					  </div>
                      </br>
					  <div class="control-group">
					    <h4><u>Course Name</u></h4>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['course_name'];?>
						    </label>
					    </div>
					  </div>
                      </br>
					  <div class="control-group">
					    <h4><u>Instructor</u></h4>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['instructor'];?>
						    </label>
					    </div>
					  </div>
                      </br>
					  <div class="form-actions">
						<a class="btn" href="registration.php">Back</a>
					  </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

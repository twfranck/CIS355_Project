<?php 

	session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}

$sessionid = $_SESSION['fr_person_id'];

	require 'database.php';

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($sessionid));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();

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
		    			<h1>Profile</h1>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					<div class='control-group'>
					<div class="controls ">
					<?php 
					if ($data['file_size'] > 0) 
						echo '<img  height=10%; width=20%; src="data:image/jpeg;base64,' . 
							base64_encode( $data['file_content'] ) . '" />'; 
					else 
						echo 'No photo on file.';
					?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					</div>
					<br/>
				    </div>
					  <div class="control-group">
					    <h4><u>First Name</u></h4>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['f_name'];?>
						    </label>
					    </div>
                      </br>
					  </div>
					  <div class="control-group">
					    <h4><u>Last Name</u></h4>
					      	<label class="checkbox">
						     	<?php echo $data['l_name'];?>
						    </label>
					  </div>
                      </br>
					  <div class="control-group">
					    <h4><u>Username</u></h4>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['username'];?>
						    </label>
					    </div>
					  </div>
                      </br>
					  <div class="form-actions">
						<a class="btn" href="index.php">Back</a>
						<a class="btn btn-success" href="user_update.php">Update</a>
					  </div>
					  </br>
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
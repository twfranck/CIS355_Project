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
		$fNameError = null;
		$lNameError = null;
		$usernameError = null;
		
		// keep track post values
		$id = $_POST['instructor_id'];
		$fName = $_POST['f_name'];
		$lName = $_POST['l_name'];
		$username = $_POST['username'];
		
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$content = file_get_contents($tmpName);
		
		// validate input
		$valid = true;
		if (empty($username)) {
			$usernameError = 'Please enter a username';
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
			
			if($fileSize > 0){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE users  set f_name = ?, l_name =?, username = ?, file_name = ?, file_size = ?, file_type = ?, file_content = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($fName,$lName,$username,$fileName,$fileSize,$fileType,$content,$sessionid));
			Database::disconnect();
			header("Location: profile.php");
			}
			else{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE users  set f_name = ?, l_name =?, username = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($fName,$lName,$username,$sessionid));
			Database::disconnect();
			header("Location: profile.php");
			}
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($sessionid));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$fName = $data['f_name'];
		$lName = $data['l_name'];
		$username = $data['username'];
		Database::disconnect();
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
		    			<h1>Update Profile</h1>
		    		</div>
    		
	    			<form class="form-horizontal" action="user_update.php?id=<?php echo $sessionid?>" method="post" enctype="multipart/form-data">
                    <div class="col-lg-5">
					  <div class="control-group <?php echo !empty($fNameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input class="form-control" name="f_name" type="text"  placeholder="First" id="inputDefault" value="<?php echo !empty($fName)?$fName:'';?>">
					      	<?php if (!empty($fNameError)): ?>
					      		<span class="help-inline"><?php echo $fNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($lNameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input class="form-control" name="l_name" type="text" placeholder="Last" id="inputDefault" value="<?php echo !empty($lName)?$lName:'';?>">
					      	<?php if (!empty($lNameError)): ?>
					      		<span class="help-inline"><?php echo $lNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input class="form-control" name="username" type="text"  placeholder="Username" id="inputDefault" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group">
						<label class="control-label">Picture</label>
							<div class="controls">
								<input type="hidden" name="MAX_FILE_SIZE" value="160000000">
								<input name="userfile" type="file" id="userfile">
							</div>
					</div>
                      </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="profile.php">Back</a>
						</div>
                    </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>


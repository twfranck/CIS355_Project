<?php 

session_start();
	
require 'database.php';
if ( !empty($_POST)) { // if not first time through
	// initialize user input validation variables
	$usernameError = null;
	$passwordError = null;
	$fNameError = null;
	$lNameError = null;

	
	// initialize $_POST variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	$f_name = $_POST['f_name'];
	$l_name = $_POST['l_name'];
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	$content = file_get_contents($tmpName);
	
	// validate user input
	$valid = true;
	if (empty($username)) {
		$usernameError = 'Please enter a username';
		$valid = false;
	}
	
	if (empty($password)) {
		$passwordError = 'Please enter a password';
		$valid = false;
	}
	
	if (empty($f_name)) {
		$fNameError = 'Please enter a first name';
		$valid = false;
	}
	
	if (empty($l_name)) {
		$lNameError = 'Please enter a last name';
		$valid = false;
	}

	// insert data
	if ($valid) 
	{
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO users (username,password,type,f_name,l_name,file_name,file_size,file_type,file_content) values(?, ?, 'user', ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($username,$passwordhash,$f_name,$l_name,$fileName,$fileSize,$fileType,$content));
		
		Database::disconnect();
		header("Location: login.php");
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
				<h1>Create New User</h1>
			</div>
	
			<form class="form-horizontal" action="new_user.php" method="post" enctype="multipart/form-data">
            <div class="col-lg-4">
				<div class="control-group <?php echo !empty($fNameError)?'error':'';?>">
					<label class="control-label">First Name</label>
					<div class="controls">
						<input class="form-control" name="f_name" type="text"  placeholder="First" id="inputDefault" value="<?php echo !empty($f_name)?$f_name:'';?>">
						<?php if (!empty($fNameError)): ?>
							<span class="help-inline"><?php echo $fNameError;?></span>
						<?php endif; ?>
					</div>
				</div>			
				<div class="control-group <?php echo !empty($lNameError)?'error':'';?>">
					<label class="control-label">Last Name</label>
					<div class="controls">
						<input class="form-control" name="l_name" type="text"  placeholder="Last" id="inputDefault" value="<?php echo !empty($l_name)?$l_name:'';?>">
						<?php if (!empty($lNameError)): ?>
							<span class="help-inline"><?php echo $lNameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					<label class="control-label">Username</label>
					<div class="controls">
						<input class="form-control" name="username" type="text"  placeholder="Username" id="inputDefault" value="<?php echo !empty($username)?$username:'';?>">
						<?php if (!empty($usernameError)): ?>
							<span class="help-inline"><?php echo $usernameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					<label class="control-label">Password</label>
					<div class="controls">
						<input class="form-control" id="password inputDefault" name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
						<?php if (!empty($passwordError)): ?>
							<span class="help-inline"><?php echo $passwordError;?></span>
						<?php endif;?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Picture</label>
					<div class="controls">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
						<input name="userfile" type="file" id="userfile">
					</div>
				</div>
			    </br>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
					<a class="btn" href="login.php">Back</a>
				</div>
			</div>
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
  </body>
</html>

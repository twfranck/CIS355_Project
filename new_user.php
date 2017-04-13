<?php 

session_start();
	
require 'database.php';
if ( !empty($_POST)) { // if not first time through
	// initialize user input validation variables
	$usernameError = null;
	$passwordError = null;

	
	// initialize $_POST variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	
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

	// insert data
	if ($valid) 
	{
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO users (username,password,type) values(?, ?, 'user')";
		$q = $pdo->prepare($sql);
		$q->execute(array($username,$passwordhash));
		
		Database::disconnect();
		header("Location: login.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Create New User</h3>
			</div>
	
			<form class="form-horizontal" action="new_user.php" method="post" enctype="multipart/form-data">

				<div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					<label class="control-label">Username</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
						<?php if (!empty($usernameError)): ?>
							<span class="help-inline"><?php echo $usernameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					<label class="control-label">Password</label>
					<div class="controls">
						<input id="password" name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
						<?php if (!empty($passwordError)): ?>
							<span class="help-inline"><?php echo $passwordError;?></span>
						<?php endif;?>
					</div>
				</div>
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
					<a class="btn" href="login.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
  </body>
</html>
<?php
	// Start or resume session, and create: $_SESSION[] array
	session_start(); 
	require 'database.php';
	if ( !empty($_POST)) { // if $_POST filled then process the form
		// initialize $_POST variables
		$username = $_POST['username']; 
		$password = $_POST['password'];
		$passwordhash = MD5($password);
		// echo $password . " " . $passwordhash; exit();
		// robot 87b7cb79481f317bde90c116cf36084b
			
		// verify the username/password
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($username,$passwordhash));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		if($data) { // if successful login set session variables
			echo "success!";
			$_SESSION['fr_person_id'] = $data['id'];
			$sessionid = $data['id'];
			$_SESSION['fr_person_title'] = $data['type'];
			Database::disconnect();
			header("Location: index.php?id=$sessionid ");
			// javascript below is necessary for system to work on github
			echo "<script type='text/javascript'> document.location = 'fr_assignments.php'; </script>";
			exit();
		}
		else { // otherwise go to login error page
			Database::disconnect();
			header("Location: login_error.html");
		}
	} 
	// if $_POST NOT filled then display login form, below.
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
		

			<div class="row page-header">
				<h1>Login</h1>
			</div>

			<form class="form-horizontal" action="login.php" method="post">
			
			<div id="wrap" class="col-lg-3">
				<div class="control-group">
					<label class="control-label">Username</label>
					<div class="controls">
						<input class="form-control" name="username" type="text"  placeholder="username" id="inputDefault" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input class="form-control" name="password" type="password" placeholder="password" id="inputDefault" required> 
					</div>	
				</div> 
				</br>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="new_user.php">Register</a>
				</div>
				
			</div>
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>

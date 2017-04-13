<?php 

session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}
$id = $_GET['id']; // for MyAssignments
$sessionid = $_SESSION['fr_person_id'];
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
    		<h1>Main Menu</h1>
    	</div>
		<div class="row col-lg-2">
			<p>
				<a href="courses.php" class="btn btn-info btn-block">Courses</a>
			</p>
			<p>
				<a href="instructors.php" class="btn btn-info btn-block">Instructors</a>
			</p>
			<p>
				<a href="registration.php" class="btn btn-info btn-block">Registered Courses</a>
			</p>
			<p>
				<a href="logout.php" class="btn btn-info btn-block">Logout</a>
			</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>

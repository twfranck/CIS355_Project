<?php 

session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');   // go to login page
	exit;
}

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
                <a href="index.php" class="btn btn-primary" style="float: right;" >Main Menu</a>
    			<h1>Instructors</h1>
    		</div>
			<div class="row">
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Instructor ID</th>
		                  <th>First Name</th>
		                  <th>Last Name</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM instructors ORDER BY instructor_id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['instructor_id'] . '</td>';
							   	echo '<td>'. $row['first_name'] . '</td>';
							   	echo '<td>'. $row['last_name'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="instructor_read.php?instructor_id='.$row['instructor_id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="instructor_update.php?instructor_id='.$row['instructor_id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="instructor_delete.php?instructor_id='.$row['instructor_id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<p>
					<a href="instructor_create.php" class="btn btn-success">Add an Instructor</a>
				</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>

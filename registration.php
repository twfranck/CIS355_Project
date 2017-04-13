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
                <h1>Registered Courses</h1>
            </div>
            <div class="row">
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Course ID</th>
                          <th>Course Name</th>
                          <th>Instructor</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php  
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT registration.course_id AS course_id, courses.course_name AS course_name, instructors.last_name AS instructor FROM registration JOIN courses ON registration.course_id = courses.course_id JOIN instructors ON registration.instructor_id = instructors.instructor_id ORDER BY course_id DESC';
                        foreach ($pdo->query($sql) as $row) {
                                   echo '<tr>';
                                   echo '<td>'. $row['course_id'] . '</td>';
                                   echo '<td>'. $row['course_name'] . '</td>';
                                   echo '<td>'. $row['instructor'] . '</td>';
                                   echo '<td width=250>';
                                   echo '<a class="btn" href="register_read.php?course_id='.$row[0].'">Read</a>';
                                   echo '&nbsp;';
                                   echo '<a class="btn btn-danger" href="register_delete.php?course_id='.$row[0].'">Drop</a>';
                                   echo '</td>';
                                   echo '</tr>';
                       }
                       Database::disconnect();
                       
                      ?>
                      </tbody>
                </table>
                <p>
                    <a href="register.php" class="btn btn-success">Register</a>
                </p>
        </div>
    </div> <!-- /container -->
  </body>
</html>

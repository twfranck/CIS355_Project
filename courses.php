<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Courses</h3>
            </div>
            <div class="row">
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Course ID</th>
                          <th>Course Name</th>
                          <th>Course Description</th>
						  <th>Instructor</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php  
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM courses ORDER BY course_id DESC';
                        foreach ($pdo->query($sql) as $row) {
                                   echo '<tr>';
                                   echo '<td>'. $row['course_id'] . '</td>';
                                   echo '<td>'. $row['course_name'] . '</td>';
                                   echo '<td>'. $row['course_description'] . '</td>';
								   echo '<td>'. $row['course_instructor'] . '<td>';
                                   echo '<td width=250>';
                                   echo '<a class="btn" href="course_read.php?course_id='.$row['course_id'].'">Read</a>';
                                   echo '&nbsp;';
                                   echo '<a class="btn btn-success" href="course_update.php?course_id='.$row['course_id'].'">Update</a>';
                                   echo '&nbsp;';
                                   echo '<a class="btn btn-danger" href="course_delete.php?course_id='.$row['course_id'].'">Delete</a>';
                                   echo '</td>';
                                   echo '</tr>';
                       }
                       Database::disconnect();
                       
                      ?>
                      </tbody>
                </table>
                <p>
                    <a href="course_create.php" class="btn btn-success">Add a New Course</a>
                </p>
        </div>
    </div> <!-- /container -->
  </body>
</html>
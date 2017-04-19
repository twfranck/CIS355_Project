<?php  
    include 'database.php';
    $pdo = Database::connect();
    $sql = 'SELECT * FROM courses';
	$arr = array();
    foreach ($pdo->query($sql) as $row) {
	array_push($arr, $row['course_id'] . ", " . $row['course_name'] . ", " . $row['course_description']);
	}
	Database::disconnect();
	
	echo '{"courses":' . json_encode($arr) . '}';
                       
?>


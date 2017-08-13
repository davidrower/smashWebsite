<html>
<body>

<?php
	$db_username = 'kicohenc_david';
	$db_password = 'Drovid!23456';
	$db_name = 'kicohenc_smash';
	$db_host = 'localhost';

	$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "INSERT INTO `players`(`tag`, `name`, `mains`, `elo`) VALUES ('".htmlspecialchars($_POST['tag'])."','".htmlspecialchars($_POST['name'])."','".htmlspecialchars($_POST['mains'])."','".htmlspecialchars($_POST[elo])."');";

	if (mysqli_query($conn, $sql)) {} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	header( 'Location: http://smash.davidrower.com' ) ;

?>

</body>
</html>
<html>
<body>

<?php
	$db_username = 'kicohenc_david';
	$db_password = 'Drovid!23456';
	$db_name = 'kicohenc_smash';
	$db_host = 'localhost';
	$win=$_POST['winner'];
	$loss=$_POST['loser'];
	$score=3;
	$score2=$_POST['score2'];
	$describe=htmlspecialchars($_POST['descr']);

	$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

//winner elo retrieved here
	$sql = "SELECT tag,elo FROM players WHERE id=$win";
	$result = mysqli_query($conn, $sql);
	

	if (mysqli_query($conn, $sql)) {} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
        	echo "Winner: ".$row['tag']." ELO: ".$row['elo']."<br>";
        	$elo=$row['elo'];
        	$tag=$row['tag'];
    	};
    } else {
        echo "0 results";
    }
//loser elo retrieved here
    $sql = "SELECT tag,elo FROM players WHERE id=$loss";
	$result = mysqli_query($conn, $sql);

		if (mysqli_query($conn, $sql)) {} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		if (mysqli_num_rows($result) > 0) {
	        // output data of each row
	        while($row = mysqli_fetch_assoc($result)) {
	        	echo "Loser: ".$row['tag']." ELO: ".$row['elo']."<br>";
	        	$elo2=$row['elo'];
	        	$tag2=$row['tag'];
	    	};
	    } else {
	        echo "0 results";
	    }
//calculations 
	    $elodiff = 0;
	    $R1= pow(10, $elo/400);
	    $R2= pow(10, $elo2/400);
	    $A=$R1/($R1+$R2);
	    $elodiff=32*(3/($score2+3)-$A);
	    $elodiff2=-32*(3/($score2+3)-$A);
//match added to record 	
	$sql = "INSERT INTO `matches`(winner, loser, winscore, losescore, elodiff, description) VALUES ('$tag','$tag2',$score,$score2,$elodiff,'$describe');";
	if (mysqli_query($conn, $sql)) {} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
//elos updated
	    $newelo=$elo+$elodiff;
	    $newelo2=$elo2+$elodiff2;
	    $sql = "UPDATE players SET elo=$newelo, diff=$elodiff WHERE id=$win";
	    if (mysqli_query($conn, $sql)) {} else {
	    	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	    }

	    $sql = "UPDATE players SET elo=$newelo2, diff=$elodiff2 WHERE id=$loss";
	    if (mysqli_query($conn, $sql)) {} else {
	    	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	    }
	    echo "<br>";
//	    echo $elo." ".$elo2." ".$A." ".$elodiff." ".$newelo." ".$newelo2;




header( 'Location: http://smash.davidrower.com' ) ;

?>

</body>
</html>
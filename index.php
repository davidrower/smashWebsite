<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<?php  
  $db_username = 'kicohenc_david';
  $db_password = 'Drovid!23456';
  $db_name = 'kicohenc_smash';
  $db_host = 'localhost';

  $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT id, name, tag, elo FROM players";

  $result = mysqli_query($conn, $sql);
?>

<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">Welcome to Pendola Smash.</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home <span class="glyphicon glyphicon-home"></span></a></li>
        <li><a data-toggle="modal" data-target="#matchModal">New Match <span class="glyphicon glyphicon-thumbs-down"></span></a></li>
        <li><a data-toggle="modal" data-target="#playerModal">New Player <span class="glyphicon glyphicon-user"></span></a></li> 
        <li><a href="about.html">About <span class="glyphicon glyphicon-question-sign"></span></a></li> 
      </ul>
    </div>
  </nav>
  <div class="container">
  <div class="rank">
    <h3>Ranking</h3>
    <table class="ranks table table-striped">
      <thead>
          <tr>
              <td><strong>Tag</strong></td>
              <td><strong>ELO (Last +/-)</strong></td>
          </tr>
      </thead>
      <tbody>
      <?php
        $sql2="SELECT tag,elo,diff FROM players ORDER BY elo DESC";
        $results = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($results) > 0) {
        // output data of each row
          while($row = mysqli_fetch_array($results)) {
          ?>
              <tr>
                  <td><?php echo $row['tag']?></td>
                  <td><?php echo $row['elo'].' ('.$row['diff'].')'?></td>
              </tr>

          <?php
          }
        } else {
           echo "0 results";
        } 
        ?>
      </tbody>
  </table>
</div>
<div class="match">
  <h3>Recent Matches</h3>
  <ul class="list-group">
    <?php  
      $sql4 = "SELECT * FROM `matches` ORDER BY matchdate DESC LIMIT 0, 10 ";
      $result4 = mysqli_query($conn, $sql4);
      if (mysqli_num_rows($result4) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result4)) {
          echo '<li class="list-group-item">'.$row['winner'].' '.$row['description'].' '.$row['loser'].' '.$row['winscore'].'-'.$row['losescore'].' ('.$row['matchdate'].')'.'</li>';
        };
      } else {
              echo "0 results";
        } 
      ?>
  </ul>
</div>
</div>
<!-- Modal -->
<div id="playerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Player</h4>
      </div>
      <div class="modal-body">
        <form action="addPlayer.php" role="form" method="post">
          <div class="form-group">
            <label for="tag">Tag:</label>
            <input type="text" class="form-control" name="tag" required>
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
              <br>
              <label for="mains">Main: </label>
              <select class="form-control" name="mains">
                <?php  
                $sql3 = "SELECT * FROM `characters` ORDER BY `characters`.`charnames` ASC LIMIT 0, 30 ";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                  // output data of each row
                  while($row = mysqli_fetch_assoc($result3)) {
                    echo '<option value="'.$row['id'].'">'.$row['charnames'].'</option>';
                  };
                } else {
                        echo "0 results";
                  } 
                ?>
              </select>
          </div>
            <div class="form-group">
              <label for="elo">Starting ELO</label>
              <input type="number" class="form-control" name="elo">
            </div>
          <div class="checkbox">
            <label><input type="checkbox">Scrub</label>
          </div>
          <br>
          <input type="submit"></input>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div id="matchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Match</h4>
      </div>
      <div class="modal-body">
        <form action="addmatch.php" role="form" method="post">
        <label for="winner">Winner</label><br>
          <select name="winner">
          <?php  
          if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              $text = '<option value="'.$row['id'].'">'.$row['name'].' ('.$row['tag'].')</option>';
              echo $text;
            };
          } else {
                  echo "0 results";
            } 
          $result = mysqli_query($conn, $sql);

          ?>
          </select>
          <br><br>
          <div class="form-group">
            <label for="score">Your Game Score: </label>
            <p> 3 </p>
          </div>
          <br>
          <label for="loser">Loser</label><br>
          <select name="loser">
          <?php  
            if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
              $text = '<option value="'.$row['id'].'">'.$row['name'].' ('.$row['tag'].')</option>';
              echo $text;
            };
          } else {
                  echo "0 results";
            }
          ?>
          </select>
          <br><br>
          <div class="form-group">
            <label for="score2">His/Her/Xyr Game Score:</label><br>
            <select name="score2">
              <option value=2>2</option>
              <option value=1>1</option>
              <option value=0>0</option>
            </select>
          </div>
          <br>
          <div class="form-group">
            <label for="descr">Verb to describe wreckage (I _____ the other player.):</label>
            <input type="text" class="form-control" name="descr" required>
          </div>
          <br>
          <input type="submit"></input>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</body>
</html>

<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "example";
    $db = "MovieDB";
    $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);
    
    $ID = mysqli_real_escape_string($conn, $_GET['ID']);

    $sql = "SELECT * FROM Movies WHERE MovieId = '$ID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
   
    if( $row['stddev'] > 1.5)
        $polarising = "Very polarising";
    else if($row['stddev'] > 1)
        $polarising = "Somewhat polarising";
    else if($row['stddev'] > 0.5)
        $polarising = "Not very polarising";
    else if($row['stddev'] <= 0.5)
        $polarising = "Not polarising" ;

   
?>

<DOCTYPE HTML>  
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>   
  <link rel="stylesheet" href="css/style.css" media="screen">
</head>
<body>  

    <!-- Navigation bar -->
    <header>
        <nav class="navbar navbar-default justify-content-between" role="navigation">
        <a class="navbar-brand" href="#">MovieDB</a>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li href="index.html"><a href="#">Home</a></li>
                <li ><a href="mostpopular.php">Most Popular</a></li>
                <li><a href="polarising.php">Most Polarising</a></li>
                
            </ul>
            <div class="col-sm-3 col-md-3 pull-right">
                <form class="navbar-form float-right" action="search.php" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>        
        </div>
        </nav>
    </header>
    <style>
         <?php include 'css/style.css'; ?>
    </style>
    <div id="details-content" class="center">
        <h1><?php echo $row['title']?></h1>        
        <h3>Year</h3>
        <p><?php echo $row['genres']?></p>
        <h3><?php echo $row['rating']?></h3>
        <h3><?php echo $polarising?></h3>
        <h3>Imbd link</h3>
        <h3>Tmdb link</h3>
        <table class='table table-hover top10-width'>
            <thead>
                <tr>
                    <th>Userid</th>
                    <th>Rating</th>
                    <th >tag</th>
                </tr>
            </thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        
        </table>

    </div>
</body>
</html>
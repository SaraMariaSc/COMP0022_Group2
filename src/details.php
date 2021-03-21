<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "example";
    $db = "MovieDB";
    $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);
    
    $ID = mysqli_real_escape_string($conn, $_GET['ID']);

    

    $sql = "SELECT * FROM Movies JOIN Links ON Movies.movieId = Links.movieId WHERE Movies.movieId = '$ID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $imdbLink = "https://www.imdb.com/title/tt".$row['imdbId']."/";
    $tmdbLink = "https://www.themoviedb.org/movie/".$row['tmdbId'];
   
    if( $row['stddev'] > 1.5)
        $polarising = "Very polarising";
    else if($row['stddev'] > 1)
        $polarising = "Somewhat polarising";
    else if($row['stddev'] > 0.5)
        $polarising = "Not very polarising";
    else if($row['stddev'] <= 0.5)
        $polarising = "Not polarising" ;

    $sql = "SELECT group_concat(distinct tags) FROM Tags WHERE movieId = '$ID'";
    $result = mysqli_query($conn, $sql);
    $tags = mysqli_fetch_array($result);

    include "useCase4.php";

    $sql = "SELECT userId, rating, movieId, timest FROM Ratings WHERE movieId = '$ID'";
    $ratings = mysqli_query($conn, $sql);
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
<body class="page-container">  
  
        <!-- Navigation bar -->
        <header>
            <nav class="navbar navbar-default justify-content-between" role="navigation">
            <a class="navbar-brand" href="index.php">MovieDB</a>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li ><a href="index.php" >Home</a></li>
                    <li ><a href="allmovies.php" >All Movies</a></li>
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
    <div class="content-wrap" >  
        <style>
            <?php include 'css/style.css'; ?>
        </style>
        <div id="details-content" class="center">
            <h1><?php echo $row['title']?></h1>        
            <h3><?php $row['release_year']?></h3>
            <p><?php echo $row['genres']?></p>
            <h3><?php echo $row['rating']?></h3>
            <h3><?php echo $polarising?></h3>
            <h3><?php echo $report?></h3>
            
            <?php 
                if(!empty($tags[0]))
                    echo "<h3>Tags: ". $tags[0] . "</h3>";
            ?>
            <h3>View on <a href=<?php echo $imdbLink?>>Imdb</a></h3>
            <h3>View on <a href=<?php echo $tmdbLink?>>Tmdb</a></h3>
            <br><br>
            <h3>What users think</h3>
            <table class='table table-hover top10-width'>
                <thead>
                    <tr>
                        <th>Userid</th>
                        <th>Rating</th>
                        <th >tag</th>
                    </tr>
                </thead>
                <?php 
                while($rating = mysqli_fetch_array($ratings)){
                    echo "<tr>";
                        echo "<td>User". $rating['userId'] ."</td>";
                        echo "<td>". $rating['rating'] ."</td>";
                        echo "<td>". date('m/d/Y', $rating['timest']) ."</td>";
                        echo "</tr>";
                }
                ?>
            </table>
            

        </div>
    </div>
    <?php include "footer.php";?>

</body>
</html>
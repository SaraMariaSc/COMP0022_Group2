<!-- 
        To use this make sure to:
         have the MovieDB database created 
         create Movie table
         populate Ratings and Movies tables
         add the new rating column to the Movie table
         add the average rating to each movie in the Movie table
         add the new stddev column to Ratings table
         add standard deviation to Movies table

        look through some_queries.php to get the code

        ratings.csv contains the reviews for movies with id betweeen 1 and 800
        movies.csv contains the movies with id between 1 and 800 -->
 
<!DOCTYPE HTML>  
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
                <li class="active"><a href="#">Home</a></li>
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

    <div class="hero-area">
        <img src="media/movie.jpg" class="banner-img">
        <h1 class="title">Welcome to Movie DB</h1>
    </div>

    <div> 
        <h1 class="center">Top 10 Movies</h1>
    <?php

        //fill out with connection params
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "example";
        $db = "MovieDB";
        $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);

        //Display top 10 movies
        $sql = "SELECT title, movieId 
                FROM Movies
                ORDER BY rating DESC LIMIT 10";

        $result = $conn->query($sql);

        echo "<table class='table table-hover top10-width'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th> </th>";
                    echo "<th >Title</th>";
                echo "</tr>";
            echo " </thead>";

        //Index for each result
        $position = 1;
        
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" .$position . "</td>";
                echo "<td><a href='details.php?ID={$row['movieId']}'> {$row['title']} </a></td>";
            echo "</tr>";
            $position = $position + 1;
        }
        echo "</table>";
        $conn->close();
?>

    </div>
</body>
</html>
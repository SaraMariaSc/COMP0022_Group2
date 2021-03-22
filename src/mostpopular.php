 
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
<body class="page-container">  
    
    <!-- Navigation bar -->
        <header>
            <nav class="navbar navbar-default justify-content-between" role="navigation">
            <a class="navbar-brand" href="index.php">MovieDB</a>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="allmovies.php">All Movies</a></li>
                    <li class="active"><a href="#">Most Popular</a></li>
                    <li><a href="polarising.php">Most Polarising</a></li>
                    
                </ul>
                <div class="col-sm-3 col-md-3 pull-right">
                    <form class="navbar-form float-right" action="search.php" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search" >
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
        <!-- otherwise it won't know to access the css -->
        <style>
            <?php include 'css/style.css'; ?>
        </style>
        <div class="results"> 
            
        <h1>Most Popular Movies </h1>
        <?php
            //create connection
            include "connect.php";

            $sql = "SELECT *
                    FROM Movies
                    ORDER BY rating DESC";
            $result = $conn->query($sql);

            echo "<table class='table table-hover'>";
            echo "<thead >";
            echo "<tr>";
                echo "<th> </th>";
                echo "<th>Movie</th>";
                echo "<th scope='col'>Year</th>";
                echo "<th scope='col'>Rating</th>";
                echo "<th scope='col'>Genres</th>";
                echo "<th scope='col'>Is it polarising?</th>";
            echo "</tr>";
            echo " </thead>";

            $position = 1;
            while($row = mysqli_fetch_array($result)){

                //get the genres
                    $genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
                    $sql_genres = "SELECT * FROM Movies WHERE movieId = '".$row['movieId']."'";
                    $genre_result = mysqli_query($conn, $sql_genres);
                    $movie_genres = mysqli_fetch_array($genre_result);
                    $genre_list = "";
                    for($i = 0; $i < count($genres); $i++){
                        if($movie_genres[$genres[$i]] == 1)
                            $genre_list .= $genres[$i] . " ";   
                    }

                echo "<tr>";
                echo "<td>" . $position . "</td>";
                echo "<td><a href='details.php?ID={$row['movieId']}'> {$row['title']} </a></td>";
                echo "<td>" . $row['release_year'] . "</td>";
                echo "<td>" . $row['rating'] . "</td>";
                echo "<td>" . $genre_list . "</td>";

                //is it polarising?
                //I observed that the max stddev is 2 and the min is 0
                echo "<td class='polarising'>";
                    if( $row['stddev'] >= 1.5)
                        echo "Very polarising";
                    else if($row['stddev'] > 1)
                        echo "Somewhat polarising";
                    else if($row['stddev'] > 0.5)
                        echo "Not very polarising";
                    else if($row['stddev'] <= 0.5)
                        echo "Not polarising" ;
                    echo "</tr>";
                echo "</td>";
                $position = $position + 1; 
            }
            echo "</table>";
        ?> 
        </div>   
    </div>
        <?php include "footer.php";?>
 
</body>
</html>
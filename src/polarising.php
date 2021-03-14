<!-- Added html
    Changed code a bit because I was getting errors

-->
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
                <li><a href="index.php">Home</a></li>
                <li><a href="mostpopular.php">Most Popular</a></li>
                <li class="active"><a href="#">Most Polarizing</a></li>
                
            </ul>
            <div class="col-sm-3 col-md-3 pull-right">
                <form class="navbar-form float-right" action="search.php" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search" name="q">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>        
        </div>
        </nav>
    </header>

    <!-- otherwise it won't know to access the css -->
    <style>
         <?php include 'css/style.css'; ?>
    </style>

    <div class="results"> 
        
        <h1>Most Polarising Movies </h1>
        <?php
            //fill out with connection params
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "example";
            $db = "MovieDB";
            $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);


            //Add standard deviation code
            //Only done once at the moment which is why it is commented out 

            // $sql_movies = "SELECT * FROM Movies";
            // $result = $conn->query($sql_movies);
            
            // while($movie =  mysqli_fetch_array($result))
            // { 
            //     $movieId = $movie['movieId'];
            //     $sql_stddev = "SELECT STDDEV_POP(rating) as sd FROM Ratings WHERE movieId = ?";//get standard deviation of ratings

            //     if($stmt = $conn->prepare($sql_stddev))
            //     {    
            //         $stmt->bind_param("s", $movieId);
            //         $stmt->execute(); 
            //         $row = mysqli_fetch_array($stmt->get_result());
            //     }
            //     else{
            //         printf('errno: %d, error: %s', $conn->errno, $conn->error);
            //         die;
            //     }
            //     //Add stddev value to table
            //     $sql_update = "UPDATE Movies SET stddev = '$row[sd]' WHERE movieId = $movieId";//change column names if necessary
            //     if(!mysqli_query($conn, $sql_update)){
            //         echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
            //     }     
                
            // }
            //Need to set up a cronjob to run this daily (0 0 * * * //thing)

            //
            $sql = "SELECT title, rating, stddev, Movies.movieId as id FROM Movies ORDER BY stddev DESC";
            $result = $conn->query($sql);

            echo "<table class='table table-hover'>";
            echo "<thead >";
            echo "<tr>";
                echo "<th> </th>";
                echo "<th>Movie</th>";
                echo "<th>Rating</th>";
                // echo "<th>Stddev</th>";
            echo "</tr>";
            echo " </thead>";

            //Index for each result
            $position = 1;
            
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $position . "</td>";
                echo "<td><a href='details.php?ID={$row['id']}'> {$row['title']} </a></td>";
                echo "<td>" . $row['rating'] . "</td>";
                // echo "<td>" . $row['stddev'] . "</td>";
                echo "</tr>";
                $position = $position + 1; 
            }
            echo "</table>";
            $conn->close();
        ?> 
    </div>
</body>
</html>
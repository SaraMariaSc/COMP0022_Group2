<?php
    // Start the session
    session_start();
?>
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
                    <li class="active"><a href="#">All Movies</a></li>
                    <li><a href="mostpopular.php">Most Popular</a></li>
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
            
        <h1>All Movies </h1>
        <div>
                <div class="sort" >
                    <h3 class="sort-item"> Sort by </h3>
                    <form class="search-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="sort-item">
                            <button class="btn btn-default" type="submit" name="title" <?php echo $filter='1'; ?>>Title</button>
                        </div >
                        <!-- <div class="sort-item">
                            <button class="btn btn-default" type="submit" name="rating" <?php echo $filter='2'; ?>>Rating</button>
                        </div> -->
                        <div class="sort-item">
                            <button class="btn btn-default" type="submit" name="year" <?php echo $filter='3'; ?>>Year</button>
                        </div>
                        <!-- <div class="sort-item">
                            <button class="btn btn-default" type="submit" name="asc" <?php echo $filter='4'; ?>>ASC</button>
                        </div>
                        <div class="sort-item">
                            <button class="btn btn-default" type="submit" name="desc" <?php echo $filter='5'; ?>>DESC</button>
                        </div> -->
                    </form>
                    
                </div>
            </div>
        <?php
            //create connection
            include "connect.php";

            //see which filter is chosen
            $orderString = ''; // default 
            if (isset($_POST['title'])){
                $orderString = "title";
            }
            // else if(isset($_POST['rating'])){
            //     $orderString = "rating";
            // }
            else if(isset($_POST['year'])){
                $orderString = "release_year";
            }
            // else if(isset($_POST['asc'])){
            //     $order = "ASC";
            // }
            // else if(isset($_POST['desc'])){
            //     $order = "DESC";
            // }
            $sql = "SELECT * FROM Movies";
            if ($orderString !== '') {
                // Add order by to the query
                $sql .= " ORDER BY " . $orderString ;
            }
            // if ($order !== '') {
            //     // Add order by to the query
            //     $sql .= " " . $order;
            // }

            $result = $conn->query($sql);

            echo "<table class='table table-hover'>";
            echo "<thead >";
            echo "<tr>";
                echo "<th> </th>";
                echo "<th>Movie</th>";
                echo "<th scope='col'>Year</th>";
                echo "<th scope='col'>Rating</th>";
                echo "<th scope='col'>Is it polarising?</th>";
            echo "</tr>";
            echo " </thead>";

            $position = 1;
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $position . "</td>";
                echo "<td><a href='details.php?ID={$row['movieId']}'> {$row['title']} </a></td>";
                echo "<td>" . $row['release_year'] . "</td>";
                echo "<td>" . $row['rating'] . "</td>";

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
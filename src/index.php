<?php
// require_once ("setup/db_setup.php");
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
        <a class="navbar-brand" href="#">MovieDB</a>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="allmovies.php">All Movies</a></li>
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

        <div class="hero-area">
            <img src="media/movie.jpg" class="banner-img">
            <h1 class="title">Welcome to Movie DB</h1>
        </div>

        <div> 
            <h1 class="center">Top 10 Movies</h1>
        <?php

            include "/var/www/html/top10movies.php";
        
        ?>

        </div>
    </div>
    <?php include "footer.php";?>
</body>
</html>
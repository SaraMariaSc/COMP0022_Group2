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
<body>  
  <header>
    <nav class="navbar navbar-default justify-content-between" role="navigation">
      <a class="navbar-brand" href="#">MovieDB</a>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="mostpopular.php">Most Popular</a></li>
              <li><a href="polarising.php">Most Polarising</a></li>
          </ul>
          <div class="col-sm-3 col-md-3 pull-right">
              <form class="navbar-form float-right" action="search.php" role="search">
                  <div class="input-group">
                      <!-- <input type="text" class="form-control" name="search" placeholder="Search" > -->
                      <input type='text' class="form-control" name='search' value='<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>' />
                      <div class="input-group-btn">
                          <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                  </div>
              </form>
          </div>        
      </div>
    </nav>
  </header>
    
    <!-- include css file here again otherwise it won't know to access the css -->
    <style>
         <?php include 'css/style.css'; ?>
    </style>
    
    <div class="results">        
        <?php
        //create connection
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "example";
        $db = "MovieDB";
        $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);
        
        //get value with name="search" from the input bar
        $input =  $_GET['search'];

        //use session to remember what the last search input was
        //without sessions the input is lost when a filter is chosen

        //if input is empty we should get the previous input for filterning purposes
        if($input == '')
        {
            $input =$_SESSION["prev_input"];
        }
        $_SESSION["prev_input"] = $input;
      ?>
      
      <h1>Search results for "<?php echo $input; ?>"</h1>
        <div>
            <div class="sort" >
                <h3 class="sort-item"> Sort by </h3>
                <form class="search-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="sort-item">
                        <button class="btn btn-default" type="submit" name="title" <?php echo $filter='1'; ?>>Title</button>
                    </div >
                    <div class="sort-item">
                        <button class="btn btn-default" type="submit" name="rating" <?php echo $filter='2'; ?>>Rating</button>
                    </div>
                    <div class="sort-item">
                        <button class="btn btn-default" type="submit" name="polarising" <?php echo $filter='3'; ?>>Most Polarising</button>
                    </div>
                </form>
                
            </div>
        </div>
      
      <?php
        //see which filter is chosen
        $orderString = ''; // default 
        if (isset($_POST['title'])){
            $orderString = "title";
        }
        else if(isset($_POST['rating'])){
            $orderString = "rating";
        }
        else if(isset($_POST['polarising'])){
            $orderString = "stddev";
        }

        //search by name, id or genre
        $searchQuery = "SELECT * FROM Movies WHERE movieId = ? OR title LIKE ? OR genres LIKE ?";

        //If filter was chosen, add "order by" in the query
        if ($orderString !== '') {
            // Concatenate
            $searchQuery .= " ORDER BY " . $orderString . " ASC";
        }

        $likeQuery = "%" . $input . "%";
        $stmt = $conn->prepare($searchQuery);
        $stmt->bind_param("sss", $input, $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result(); 
          
        echo "<table class='table table-hover'>";
            echo "<thead >";
                echo "<tr>";
                    echo "<th> </th>";
                    echo "<th scope='col'>Movie</th>";
                    echo "<th scope='col'>Genres</th>";
                    echo "<th scope='col'>Rating</th>";
                    echo "<th scope='col'>Is it polarising?</th>";
                echo "</tr>";
            echo " </thead>";

        $position = 1;
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $position . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['genres'] . "</td>";
            echo "<td>" . $row['rating'] . "</td>";

            //is it polarising?
            //I observed that the max stddev is 2 and the min is 0
            echo "<td class='polarising'>";
                if( $row['stddev'] > 1.5)
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

</body>
</html>
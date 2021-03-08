<?php
        //create connection
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "example";
        $db = "MovieDB";
        $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);

//Populate Ratings table
// open file
$filename = 'ratings.csv';
$file = fopen($filename, "r");
fgetcsv($file, 100, ",");
while (($column = fgetcsv($file, 200, ",")) !== FALSE) {

    $userId = mysqli_real_escape_string($conn, $column[0]);
    $movieId = mysqli_real_escape_string($conn, $column[1]);
    $rating = mysqli_real_escape_string($conn, $column[2]);
    $timestamp = mysqli_real_escape_string($conn, $column[3]);

    //rename timestamp -> timest
    $sql = "INSERT INTO Ratings (ratingId, userId, movieId, rating, timest) VALUES 
    (0, $userId, $movieId, $rating, $timestamp)";

    if (!($conn->query($sql) === TRUE)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}


        //Creating Movies table
$movieFile = "movies.csv";
$file = fopen($movieFile, "r");
// sql to create table
$sql = "CREATE TABLE Movies (
    movieId INT(10) NOT NULL,
    title VARCHAR(50) NOT NULL,
    genres VARCHAR(50) NOT NULL
    )";
    
if ($conn->query($sql) === TRUE) {
    echo "Table Movies created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

//Populating the Movie table
$movieFile = 'movies.csv';
$file = fopen($movieFile, "r");

//Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
//maximum line length is not limited, which is slightly slower but fewer problems
fgetcsv($file, 0, ",");

$new_entry = array();
while (($column = fgetcsv($file, 0, ",")) !== FALSE) {

    $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[0]);
    $new_entry['title']  = mysqli_real_escape_string($conn, $column[1]);
    $new_entry['genres']  = mysqli_real_escape_string($conn, $column[2]);

    $sql = "INSERT INTO Movies (movieId, title, genres) VALUES ('".$new_entry['movieId']."', '".$new_entry['title']."', '".$new_entry['genres']."')";

    if (!($conn->query($sql) === TRUE)) {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<br>";
    }
}

//add rating column
$sql1 = "ALTER TABLE Movies ADD rating float";
if(mysqli_query($conn, $sql1)){
    echo "column was added successfully.";
} 
else{
    echo "ERROR: Could not execute $sql1. " . mysqli_error($link);
}


//Add average movie rating to eac movie in the Movie table
//Using prepared statements
$sql_movies = "SELECT * FROM Movies";
$result = $conn->query($sql_movies);

while($movie =  mysqli_fetch_array($result))
{
    $movieId = $movie['movieId'];
  
    $sql_rating = "SELECT AVG(rating) AS avg_rating FROM Ratings WHERE movieId = ?";
    if( $stmt = $conn->prepare($sql_rating))
        $stmt->bind_param("s", $movieId);
    $stmt->execute();
    $result_rating = $stmt->get_result(); 
    $row = mysqli_fetch_array($result_rating);
    //echo $movieId." ".$row['avg_rating']."<br>";
    $sql_update = "UPDATE Movies SET rating = '$row[avg_rating]' WHERE movieId = $movieId";
   
    if(!mysqli_query($conn, $sql_update)){
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
    } 

}
 //Creating Tags table
 $movieFile = "tags.csv";
 $file = fopen($movieFile, "r");
 // sql to create table
 $sql = "CREATE TABLE Tags (
         userId INT(10) NOT NULL,
         movieId INT(10) NOT NULL,
         tags VARCHAR(200) NOT NULL,
         timest INT(50)
         )";
     
 if ($conn->query($sql) === TRUE) {
     echo "Table Tags created successfully";
 } else {
     echo "Error creating table: " . $conn->error;
 }

 //Populating the Tags table
 $movieFile = 'tags.csv';
 $file = fopen($movieFile, "r");

 //Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
 //maximum line length is not limited, which is slightly slower but fewer problems
 fgetcsv($file, 0, ",");

 $new_entry = array();
 while (($column = fgetcsv($file, 0, ",")) !== FALSE) {
     $new_entry['userId'] = mysqli_real_escape_string($conn, $column[0]);
     $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[1]);
     $new_entry['tags']  = mysqli_real_escape_string($conn, $column[2]);
     $new_entry['timest']  = mysqli_real_escape_string($conn, $column[3]);

     $sql = "INSERT INTO Tags (userId, movieId, tags, timest) VALUES ('".$new_entry['userId']."', '".$new_entry['movieId']."', '".$new_entry['tags']."', '".$new_entry['timest']."')";

     if (!($conn->query($sql) === TRUE)) {
         echo "Error: " . $sql . "<br>" . $conn->error;
         echo "<br>";
     }
}

//add stddev column
$sql1 = "ALTER TABLE Movies ADD stddev float";
if(mysqli_query($conn, $sql1)){
    echo "column was added successfully.";
} 
else{
    echo "ERROR: Could not execute $sql1. " . mysqli_error($link);
}

//Add standard deviation code 

$sql_movies = "SELECT * FROM Movies";
$result = $conn->query($sql_movies);

while($movie =  mysqli_fetch_array($result))
{ 
    $movieId = $movie['movieId'];
    $sql_stddev = "SELECT STDDEV_POP(rating) as sd FROM Ratings WHERE movieId = ?";//get standard deviation of ratings

    if($stmt = $conn->prepare($sql_stddev))
    {    
        $stmt->bind_param("s", $movieId);
        $stmt->execute(); 
        $row = mysqli_fetch_array($stmt->get_result());
    }
    else{
        printf('errno: %d, error: %s', $conn->errno, $conn->error);
        die;
    }
    //Add stddev value to table
    $sql_update = "UPDATE Movies SET stddev = '$row[sd]' WHERE movieId = $movieId";//change column names if necessary
    if(!mysqli_query($conn, $sql_update)){
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
    }     
    
}
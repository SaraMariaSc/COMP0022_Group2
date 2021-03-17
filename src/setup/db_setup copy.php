<?php
//create connection to the MovieDB2 database

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "example";
$db = "MovieDB";
$conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);
// $conn = mysqli_connect("localhost", "root", "example");
// $sql = "CREATE TABLE IF NOT EXISTS Movies (
//     movieId INT(10) NOT NULL,
//     title VARCHAR(50) NOT NULL,
//     genres VARCHAR(50) NOT NULL,
//     stddev FLOAT(20),
//     rating FLOAT(20)
//     )";
    
// if ($conn->query($sql) === TRUE) {
//     echo "Table Movies created successfully";
// } 
// else 
// {
//     echo "Error creating table: " . $conn->error;
// }

// //Create Tags table
// $sql = "CREATE TABLE IF NOT EXISTS Tags (
//         userId INT(10) NOT NULL,
//         movieId INT(10) NOT NULL,
//         tags VARCHAR(200) NOT NULL,
//         timest INT(50)
//         )";
// if ($conn->query($sql) === TRUE) {
//     echo "Table Tags created successfully";
// } 
// else 
// {
//     echo "Error creating table: " . $conn->error;
// }

//Create Ratings table
// $sql = "CREATE TABLE IF NOT EXISTS Ratings (
//     ratingId INT(10) NOT NULL AUTO_INCREMENT,
//     userId INT(10) NOT NULL,
//     movieId INT(10) NOT NULL,
//     rating FLOAT(20) NOT NULL,
//     timest INT(50),
//     PRIMARY KEY (ratingId)
//     )";
// if ($conn->query($sql) === TRUE) {
// echo "Table Tags created successfully";
// } 
// else 
// {
// echo "Error creating table: " . $conn->error;
// }

// $sql = "CREATE TABLE IF NOT EXISTS Links (
//     movieId INT(10) NOT NULL,
//     imdbId VARCHAR(15) NOT NULL,
//     tmdbId VARCHAR(15) NOT NULL
//     )";
// if ($conn->query($sql) === TRUE) {
// echo "Table Links created successfully";
// } 
// else 
// {
// echo "Error creating table: " . $conn->error;
// }

// $genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
// $sql = "CREATE TABLE IF NOT EXISTS  Users (userId INT(10) NOT NULL";
// for ($i = 0; $i < count($genres); $i++){
//     $sql .= (", " . $genres[$i] . " float");
// }
// $sql .= ");";
// //echo $sql;
// if($conn->query($sql) === TRUE){
//     echo "Table Users created successfully";
// }
// else{
//     echo "Error creating table: " . $conn->error;
// }

//     //POPULATE TABLES

// //Populate Ratings table
// $filename = 'ratings.csv';
// $file = fopen($filename, "r");
// fgetcsv($file, 0, ",");
// while (($column = fgetcsv($file, 0, ",")) !== FALSE) 
// {
//     $userId = mysqli_real_escape_string($conn, $column[0]);
//     $movieId = mysqli_real_escape_string($conn, $column[1]);
//     $rating = mysqli_real_escape_string($conn, $column[2]);
//     $timestamp = mysqli_real_escape_string($conn, $column[3]);

//     $sql = "INSERT INTO Ratings (ratingId, userId, movieId, rating, timest) VALUES 
//     (0, $userId, $movieId, $rating, $timestamp)";

//     if (!($conn->query($sql) === TRUE)) {
//         echo "Error inserting into Ratings: " . $sql . "<br>" . $conn->error;
//     }
// }

// $movieFile = 'movies.csv';
// $file = fopen($movieFile, "r");
// //Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
// //maximum line length is not limited, which is slightly slower but fewer problems
// fgetcsv($file, 0, ",");
// //don't use the first line with the column names
// $new_entry = array();
// while (($column = fgetcsv($file, 0, ",")) !== FALSE) {

//     $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[0]);
//     $new_entry['title']  = mysqli_real_escape_string($conn, $column[1]);
//     $new_entry['genres']  = mysqli_real_escape_string($conn, $column[2]);

//     $sql = "INSERT INTO Movies (movieId, title, genres, rating, stddev) VALUES ('".$new_entry['movieId']."', '".$new_entry['title']."', '".$new_entry['genres']."', 0,0)";

//     if (!($conn->query($sql) === TRUE)) {
//         echo "Error inserting int Movies: " . $sql . "<br>" . $conn->error;
//         echo "<br>";
//     }
// }


// //Add average movie rating to eac movie in the Movie table
// //Using prepared statements
// $sql_movies = "SELECT * FROM Movies";
// $result = $conn->query($sql_movies);

// while($movie =  mysqli_fetch_array($result))
// {
//     $movieId = $movie['movieId'];
//     $sql_rating = "SELECT AVG(rating) AS avg_rating FROM Ratings WHERE movieId = ?";
//     if( $stmt = $conn->prepare($sql_rating))
//         $stmt->bind_param("s", $movieId);
//     $stmt->execute();
//     $result_rating = $stmt->get_result(); 
//     $row = mysqli_fetch_array($result_rating);
//     $avg =  round($row['avg_rating'],1 ); 
//     $sql_update = "UPDATE Movies SET rating = '$avg' WHERE movieId = $movieId";
//     if(!mysqli_query($conn, $sql_update)){
//         echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
//     } 
// }

// Add standard deviation for determining if it is Polarising
// $sql_movies = "SELECT * FROM Movies";
// $result = $conn->query($sql_movies);
// while($movie =  mysqli_fetch_array($result))
// { 
//    $movieId = $movie['movieId'];
//    $sql_stddev = "SELECT STDDEV_POP(rating) as sd FROM Ratings WHERE movieId = ?";//get standard deviation of ratings
//    if($stmt = $conn->prepare($sql_stddev))
//    {    
//        $stmt->bind_param("s", $movieId);
//        $stmt->execute(); 
//        $row = mysqli_fetch_array($stmt->get_result());
//    }
//    else{
//        printf('errno: %d, error: %s', $conn->errno, $conn->error);
//        die;
//    }
//    //Add stddev value to table
//     $avg =  round($row['sd'],1 );       
//    $sql_update = "UPDATE Movies SET stddev = '$avg' WHERE movieId = $movieId";//change column names if necessary
//    if(!mysqli_query($conn, $sql_update)){
//        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
//    } 
// }

// //Populating the Tags table
// $movieFile = 'tags.csv';
// $file = fopen($movieFile, "r");
// //Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
// //maximum line length is not limited, which is slightly slower but fewer problems
// fgetcsv($file, 0, ",");
// $new_entry = array();
// while (($column = fgetcsv($file, 0, ",")) !== FALSE) 
// {
//     $new_entry['userId'] = mysqli_real_escape_string($conn, $column[0]);
//     $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[1]);
//     $new_entry['tags']  = mysqli_real_escape_string($conn, $column[2]);
//     $new_entry['timest']  = mysqli_real_escape_string($conn, $column[3]);

//     $sql = "INSERT INTO Tags (userId, movieId, tags, timest, stddev) VALUES ('".$new_entry['userId']."', '".$new_entry['movieId']."', '".$new_entry['tags']."', '".$new_entry['timest']."', 0)";

//     if (!($conn->query($sql) === TRUE)) {
//         echo "Error inserting into Tags: " . $sql . "<br>" . $conn->error;
//         echo "<br>";
//     }
// }

// $genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
// $sql_users = "SELECT userId FROM Ratings GROUP BY userId";
// $result_users = $conn->query($sql_users);
// while($user =  mysqli_fetch_array($result_users)){
//     $userId = $user['userId'];
//     $genre_rating = Array();
//     for ($j = 0; $j < count($genres); $j++)
//     {
//         $current_genre = "%".$genres[$j]."%";
//         $sql = "SELECT AVG(Ratings.rating) FROM Ratings INNER JOIN Movies ON Ratings.movieId = Movies.movieId WHERE userId = '".$userId."' AND genres LIKE '$current_genre'";
//         $result = $conn->query($sql);
//         if (!$result) {
//             printf("Error: %s\n", mysqli_error($conn));
//             exit();
//         }
//         $row = mysqli_fetch_array($result);
//         if(!empty($row[0]))
//             array_push($genre_rating, round($row[0],1));   
//         else 
//             array_push($genre_rating,-1);
//     }
//     $sql = "INSERT INTO Users (userId ";
//     for ($i = 0; $i < count($genres); $i++)
//     {
//         $sql .= (", " . $genres[$i] );
//     }
//     $sql .= ") VALUES ($userId";
//     for ($i = 0; $i < count($genres); $i++)
//     {
//         $sql .= (", " . $genre_rating[$i] );
//     }
//     $sql .= ");";
//     if(!($conn->query($sql) === TRUE))
//     {
//         echo "Error creating table: " . $conn->error;
//     }
// }



// $movieFile = 'csv/links.csv';
// $file = fopen($movieFile, "r");
// //Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
// //maximum line length is not limited, which is slightly slower but fewer problems
// fgetcsv($file, 0, ",");
// //don't use the first line with the column names
// $new_entry = array();
// while (($column = fgetcsv($file, 0, ",")) !== FALSE) {

//     $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[0]);
//     $new_entry['imdbId']  = mysqli_real_escape_string($conn, $column[1]);
//     $new_entry['tmdbId']  = mysqli_real_escape_string($conn, $column[2]);

//     $sql = "INSERT INTO Links (movieId, imdbId, tmdbId) VALUES ('".$new_entry['movieId']."', '".$new_entry['imdbId']."', '".$new_entry['tmdbId']."')";

//     if (!($conn->query($sql) === TRUE)) {
//         echo "Error inserting into Links: " . $sql . "<br>" . $conn->error;
//         echo "<br>";
//     }
// }  
?>


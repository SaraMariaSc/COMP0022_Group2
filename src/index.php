<?php
//fill out with connection params
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "example";
$db = "MovieDB";
$conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);

//To use this make sure to:
//  have the MovieDB database created 
//  create Movie table
//  populate Rating and Movie tables
//  add the new rating column to the Movie table
//  add the average rating to each movie in the Movie table

//look through some_queries.php to get the code

//ratings.csv contains the reviews for movies with id betweeen 1 and 150
//movies contains the movies with id between 1 and 150
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
        echo $movieId." ".$row['avg_rating']."<br>";
    $sql_update = "UPDATE Movies SET rating = '$row[avg_rating]' WHERE movieId = $movieId";
   
    if(!mysqli_query($conn, $sql_update)){
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
    } 

}

//not case sensitive
include "search.html";

//Closing the connection
$conn->close();

?>
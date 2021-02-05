<?php
//fill out with connection params
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "example";
$db = "company1";
$conn = new mysqli("db", "root", "example", "company1") or die("Connect failed: %s\n". $conn -> error);

//file path
$filename = 'ratings.csv';

//open file
$file = fopen($filename, "r");

while (($column = fgetcsv($file, 100, ",")) !== FALSE) {

    $userId = mysqli_real_escape_string($conn, $column[0]);
    $movieId = mysqli_real_escape_string($conn, $column[1]);
    $rating = mysqli_real_escape_string($conn, $column[2]);
    $timestamp = mysqli_real_escape_string($conn, $column[3]);



    //rename timestamp -> timest
    $sql = "INSERT INTO Rating (ratingId, userId, movieId, rating, timest) VALUES 
    (0, $userId, $movieId, $rating, $timestamp)";

    if ($conn->query($sql) === TRUE) {
    echo "created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

}
  
$conn->close();

?>
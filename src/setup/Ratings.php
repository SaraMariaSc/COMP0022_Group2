<?php
// Create Ratings table
$sql = "CREATE TABLE IF NOT EXISTS Ratings (
    ratingId INT(10) NOT NULL AUTO_INCREMENT,
    userId INT(10) NOT NULL,
    movieId INT(10) NOT NULL,
    rating FLOAT(20) NOT NULL,
    timest INT(50),
    PRIMARY KEY (ratingId)
    )";
if (!$conn->query($sql) === TRUE) {

    echo "Error creating table Ratings: " . $conn->error;
    exit();
}

//Populate Ratings table
$filename = '/var/www/html/setup/csv/ratings.csv';
$file = fopen($filename, "r");
fgetcsv($file, 0, ",");
while (($column = fgetcsv($file, 0, ",")) !== FALSE) 
{
    $userId = mysqli_real_escape_string($conn, $column[0]);
    $movieId = mysqli_real_escape_string($conn, $column[1]);
    $rating = mysqli_real_escape_string($conn, $column[2]);
    $timestamp = mysqli_real_escape_string($conn, $column[3]);

    $sql = "INSERT INTO Ratings (ratingId, userId, movieId, rating, timest) VALUES 
    (0, $userId, $movieId, $rating, $timestamp)";

    if (!($conn->query($sql) === TRUE)) {
        echo "Error inserting into Ratings: " . $sql . "<br>" . $conn->error;
        exit();
    }
}
?>
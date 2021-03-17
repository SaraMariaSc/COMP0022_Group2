<?php
$sql = "CREATE TABLE IF NOT EXISTS Links (
    movieId INT(10) NOT NULL,
    imdbId VARCHAR(15) NOT NULL,
    tmdbId VARCHAR(15) NOT NULL
    )";
if (!$conn->query($sql) === TRUE) {
    echo "Error creating table: " . $conn->error;
    exit();
}

$movieFile = '/var/www/html/setup/csv/links.csv';
$file = fopen($movieFile, "r");
//Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
//maximum line length is not limited, which is slightly slower but fewer problems
fgetcsv($file, 0, ",");
//don't use the first line with the column names
$new_entry = array();
while (($column = fgetcsv($file, 0, ",")) !== FALSE) {

    $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[0]);
    $new_entry['imdbId']  = mysqli_real_escape_string($conn, $column[1]);
    $new_entry['tmdbId']  = mysqli_real_escape_string($conn, $column[2]);

    $sql = "INSERT INTO Links (movieId, imdbId, tmdbId) VALUES ('".$new_entry['movieId']."', '".$new_entry['imdbId']."', '".$new_entry['tmdbId']."')";

    if (!($conn->query($sql) === TRUE)) {
        echo "Error inserting into Links: " . $sql . "<br>" . $conn->error;
        echo "<br>";
        exit();
    }
} 
?>
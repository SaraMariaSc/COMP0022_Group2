<?php
//Create Tags table
$sql = "CREATE TABLE IF NOT EXISTS Tags (
    userId INT(10) NOT NULL,
    movieId INT(10) NOT NULL,
    tags VARCHAR(200) NOT NULL,
    timest INT(50)
    )";
if (!$conn->query($sql) === TRUE) {
    echo "Error creating table: " . $conn->error;
    exit();
}

//Populating the Tags table
$movieFile = '/var/www/html/setup/csv/tags.csv';
$file = fopen($movieFile, "r");
//Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
//maximum line length is not limited, which is slightly slower but fewer problems
fgetcsv($file, 0, ",");
$new_entry = array();
while (($column = fgetcsv($file, 0, ",")) !== FALSE) 
{
    $new_entry['userId'] = mysqli_real_escape_string($conn, $column[0]);
    $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[1]);
    $new_entry['tags']  = mysqli_real_escape_string($conn, $column[2]);
    $new_entry['timest']  = mysqli_real_escape_string($conn, $column[3]);

    $sql = "INSERT INTO Tags (userId, movieId, tags, timest) VALUES ('".$new_entry['userId']."', '".$new_entry['movieId']."', '".$new_entry['tags']."', '".$new_entry['timest']."')";

    if (!($conn->query($sql) === TRUE)) {
        echo "Error inserting into Tags: " . $sql . "<br>" . $conn->error;
        echo "<br>";
    }
}
?>
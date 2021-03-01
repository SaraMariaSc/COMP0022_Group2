<?php

//fill out with connection params
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "example";
$db = "company1";
$conn = new mysqli("db", "root", "example", "company1") or die("Connect failed: %s\n". $conn -> error);

$numOfMovies = "SELECT MAX(movieId) FROM Movies";
$temp = mysqli_query($conn, $numOfMovies);
$row = mysqli_fetch_array($temp);
$total = $row[0];
for ($i = 1; $i <= $total; $i ++){
    $sql = "SELECT STDDEV_POP(rating) FROM Rating WHERE movieId = $i";//get standard deviation of ratings
    $temp = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($temp);//store in result the length 1 array to insert into the table

    $sql = "SELECT AVG(rating) FROM Rating WHERE movieId = $i";//these 3 and the second prepared statement do the same for average
    $temp = mysqli_query($conn, $sql);
    $avgResult = mysqli_fetch_array($temp);

    $stmt = $conn->prepare("UPDATE Movies SET stddev = $result[0] WHERE movieId = $i");//change column names if necessary
    $stmt->execute();//updates newly calculated values into the tables
    $stmt = $conn->prepare("UPDATE Movies SET avg = $avgResult[0] WHERE movieId = $i");
    $stmt->execute();
}//Need to set up a cronjob to run this daily (0 0 * * * //thing)

$stmt->close();
$conn->close();

?>
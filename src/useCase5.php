<?php
include "connect.php";

$genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
        
$ID = mysqli_real_escape_string($conn, $_GET['ID']);
$sql = "SELECT group_concat(distinct tags) FROM Tags WHERE movieId = '$ID'";
if(! mysqli_query($conn, $sql)===TRUE)
    echo "Error: " . $conn->error;

$result = mysqli_query($conn, $sql);
$tags = mysqli_fetch_array($result);
$xTags = explode(",",$tags[0]);
// var_dump( $xTags);
    $avg=0;
    for($i=0 ;$i<count($xTags);$i++)
    {
        $likeStr = "%".$xTags[$i]."%";
        $sql = "SELECT AVG(Ratings.rating) AS avg FROM Ratings INNER JOIN Tags ON Tags.movieId = Ratings.movieId WHERE tags LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $likeStr);

        $stmt->execute();
        $result = $stmt->get_result(); 
        $row = mysqli_fetch_array($result);
        $avg +=  round($row['avg'],2 );
        
    }
    $pedicted_rating =  $avg/count($xTags);
?>
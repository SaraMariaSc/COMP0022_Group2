<?php
$genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
$sql = "CREATE TABLE IF NOT EXISTS  Users (userId INT(10) NOT NULL";
for ($i = 0; $i < count($genres); $i++){
    $sql .= (", " . $genres[$i] . " float");
}
$sql .= ");";
//echo $sql;
if(!$conn->query($sql) === TRUE){
    echo "Error creating table: " . $conn->error;
    exit();
}

$sql_users = "SELECT userId FROM Ratings GROUP BY userId";
$result_users = $conn->query($sql_users);
while($user =  mysqli_fetch_array($result_users)){
    $userId = $user['userId'];
    $genre_rating = Array();
    for ($j = 0; $j < count($genres); $j++)
    {
        $current_genre = "%".$genres[$j]."%";
        $sql = "SELECT AVG(Ratings.rating) FROM Ratings INNER JOIN Movies ON Ratings.movieId = Movies.movieId WHERE userId = '".$userId."' AND genres LIKE '$current_genre'";
        $result = $conn->query($sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        $row = mysqli_fetch_array($result);
        if(!empty($row[0]))
            array_push($genre_rating, round($row[0],1));   
        else 
            array_push($genre_rating,-1);
    }
    $sql = "INSERT INTO Users (userId ";
    for ($i = 0; $i < count($genres); $i++)
    {
        $sql .= (", " . $genres[$i] );
    }
    $sql .= ") VALUES ($userId";
    for ($i = 0; $i < count($genres); $i++)
    {
        $sql .= (", " . $genre_rating[$i] );
    }
    $sql .= ");";
    if(!($conn->query($sql) === TRUE))
    {
        echo "Error creating table: " . $conn->error;
    }
}

?>
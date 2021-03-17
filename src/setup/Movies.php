<?php

$genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];

$sql = "CREATE TABLE IF NOT EXISTS Movies (
    movieId INT(10) NOT NULL,
    title VARCHAR(200) NOT NULL,
    release_year YEAR,
    stddev FLOAT(20),
    rating FLOAT(20)";
for ($i = 0; $i < count($genres); $i++){
    $sql .= (",". addslashes($genres[$i]). " binary");
}
$sql .= ");";
if (!$conn->query($sql) === TRUE) {
    echo "Error creating table: " . $conn->error;
    exit();
}

$movieFile = '/var/www/html/setup/csv/movies.csv';
$file = fopen($movieFile, "r");
//Omitting this parameter (or setting it to 0 in PHP 5.1.0 and later) the 
//maximum line length is not limited, which is slightly slower but fewer problems
fgetcsv($file, 0, ",");
//don't use the first line with the column names
$new_entry = array();
while (($column = fgetcsv($file, 0, ",")) !== FALSE) {

    $new_entry['movieId'] = mysqli_real_escape_string($conn, $column[0]);
    $new_entry['title']  = mysqli_real_escape_string($conn, $column[1]);
    $new_entry['genres']  = mysqli_real_escape_string($conn, $column[2]);

    //reove the "-" from Film-Noir
    $new_entry['genres'] = str_replace("-", "", $new_entry['genres']);

    //Get the year
    $year=substr($new_entry['title'], -7);
    $new_entry['title'] = str_replace($year, "", $new_entry['title']);
    $paren =array("(",")"," ");
    $year = str_replace($paren,"",$year);
    
    $has_genre = array();
    for ($i = 0; $i < count($genres); $i++)
    {
        if(strpos($new_entry['genres'], $genres[$i])===FALSE){
            array_push($has_genre, 0);
        }
        else{
            array_push($has_genre, 1);
        }
    }
    $sql = "INSERT INTO Movies (movieId, title, rating, stddev, release_year";
    for ($i = 0; $i < count($genres); $i++)  
    {
        $sql .= (", " . $genres[$i]) ;
    }
    $sql = $sql . ") VALUES ('".$new_entry['movieId']."', '".$new_entry['title']."', 0,0,'".$year."'";
    for ($i = 0; $i < count($genres); $i++)
    {
        $sql = $sql . (", " . $has_genre[$i]);
    }
    $sql= $sql . ");";
    if (!($conn->query($sql) === TRUE)) {
        echo "Error inserting int Movies: " . $sql . "<br>" . $conn->error;
        exit();
    }
}

// Add average movie rating to eac movie in the Movie table
// Using prepared statements
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
    $avg =  round($row['avg_rating'],1 ); 
    $sql_update = "UPDATE Movies SET rating = '$avg' WHERE movieId = $movieId";
    if(!mysqli_query($conn, $sql_update)){
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
        exit();
    } 
}

// Add standard deviation for determining if it is Polarising
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
       exit();
    }
   //Add stddev value to table
    $avg =  round($row['sd'],1 );       
    $sql_update = "UPDATE Movies SET stddev = '$avg' WHERE movieId = $movieId";//change column names if necessary
    if(!mysqli_query($conn, $sql_update)){
       echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
       exit();
   } 
}
?>


<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "example";
$db = "MovieDB";
$conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);


//right now just search by movieId, title and genres
//uses prepared statements

//add search bar to this page as well
include 'search.html';

//get value with name="id" in search.html
$input =  $_GET['id'];
$searchQuery = "SELECT title, genres FROM Movies WHERE movieId = ? OR title LIKE ? OR genres LIKE ?";
$likeQuery = "%" . $input . "%";
$stmt = $conn->prepare($searchQuery);
$stmt->bind_param("sss", $input, $likeQuery, $likeQuery);
$stmt->execute();
$result = $stmt->get_result(); 

echo "<table>";
echo "<tr>";
    echo "<th>Movie</th>";
    echo "<th> Genres</th>";
echo "</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['genres'] . "</td>";
    echo "</tr>";
}
echo "</table>";
   

?>
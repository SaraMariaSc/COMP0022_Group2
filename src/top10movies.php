<?php
include "connect.php";
//Display top 10 movies
$sql = "SELECT title, movieId 
FROM Movies
ORDER BY rating DESC, title  LIMIT 10";

$result = $conn->query($sql);

echo "<table class='table table-hover top10-width'>";
echo "<thead>";
    echo "<tr>";
        echo "<th> </th>";
        echo "<th >Title</th>";
    echo "</tr>";
echo " </thead>";

//Index for each result
$position = 1;

while($row = mysqli_fetch_array($result)){
echo "<tr>";
    echo "<td>" .$position . "</td>";
    echo "<td><a href='details.php?ID={$row['movieId']}'> {$row['title']} </a></td>";
echo "</tr>";
$position = $position + 1;
}
echo "</table>";
?>
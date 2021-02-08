<?php
// Display all entries
$sql = "SELECT * FROM Rating";
if($result = mysqli_query($conn, $sql)){
    echo "<table>";
        echo "<tr>";
            echo "<th>ratingId</th>";
            echo "<th>userId</th>";
            echo "<th>movieId</th>";
            echo "<th>rating</th>";
        echo "</tr>";
    while($row = mysqli_fetch_array($result)){
        
            echo "<tr>";
                echo "<td>" . $row['ratingId'] . "</td>";
                echo "<td>" . $row['userId'] . "</td>";
                echo "<td>" . $row['movieId'] . "</td>";
                echo "<td>" . $row['rating'] . "</td>";
            echo "</tr>";
       
    } echo "</table>";
}

//Delete all entries
$sql1 = "DELETE FROM Rating";
if(mysqli_query($conn, $sql1)){
    echo "Records were deleted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

//Delete entry with ratingId 600
$sql1 = "DELETE FROM Rating WHERE ratingId = 600";
if(mysqli_query($conn, $sql1)){
    echo "Records were deleted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
?>
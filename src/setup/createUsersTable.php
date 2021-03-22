<?php
        //fill out with connection params
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "example";
        $db = "MovieDB";
        $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);

        $genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];

        $sql = "CREATE TABLE Users (userId INT(10) NOT NULL";
        for ($i = 0; $i < count($genres); $i++){
            $sql .= (", " . $genres[$i] . " float");
        }
        $sql .= ");";
        //echo $sql;
        if($conn->query($sql) === TRUE){
            echo "Table Users created successfully";
        }
        else{
            echo "Error creating table: " . $conn->error;
        }
        
        $maxUserId = 610;//change to get these from database
        $maxFilmId = 193609;
        for ($i = 1; $i <= $maxUserId; $i++){
            for ($j = 0; $j < count($genres); $j++){
                $sql = "SELECT AVG(Ratings.rating) FROM Ratings INNER JOIN Movies ON Ratings.movieId = Movies.movieId WHERE userId = $i AND $genres[$j] = 1";
                //echo $sql;
                $result = $conn->query($sql);
                //echo $result[1];
                $row = mysqli_fetch_array($result);
                if ($j == 0){
                    $sql2 = "INSERT INTO Users (userId, $genres[$j]) VALUES ($i, $row[0])";
                }
                else{
                    $sql2 = "UPDATE Users SET $genres[$j] = $row[0] WHERE userId = $i";
                }
                echo $sql2;
                if ($conn->query($sql2) === TRUE) {
                    echo "User updated";
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }
            }
        }
        $conn->close();
?>
<?php
        //fill out with connection params
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "example";
        $db = "MovieDB";
        $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);
        

        $genres = ["Action", "Adventure", "Animation", "Children", "Comedy", "Crime", "Documentary", "Drama", "Fantasy", "FilmNoir", "Horror", "Musical", "Mystery", "Romance", "SciFi",  "Thriller", "War", "Western"];
        
        $ID = mysqli_real_escape_string($conn, $_GET['ID']);

        $sql = "SELECT group_concat(distinct tags) FROM Tags WHERE movieId = '$ID'";
        $result = mysqli_query($conn, $sql);
        $tags = mysqli_fetch_array($result);
        $genreSQL = "SELECT * FROM Movies WHERE movieId = $ID";
        $genreResult = $conn->query($genreSQL);

        $xGenres = array();
        if ($genreResult->num_rows > 0){
            while($row = $genreResult->fetch_assoc()){
                //print_r($row);
                for ($i = 0; $i < count($genres); $i ++){
                    
                    if ($row[$genres[$i]] == 1){
                        array_push($xGenres, $genres[$i]);
                    }
                }
            }
        }
        
        //$xGenres = ["Action", "Adventure"];//genres for film x
        //$xTags = ["remake", "pixar"];//tags for film x
        $xTags = $tags;

        $xGenresStr = "(" . $xGenres[0];
        for ($i = 1; $i < count($xGenres); $i++){
            $xGenresStr .= " + " . $xGenres[$i];
        }
        $xGenresStr .= ")/" . count($xGenres);

        $genreCount = count($xGenres);

        $sum = "AVG(IFNULL(" . $xGenres[0] . ", 2.75))/$genreCount";
        for ($i = 1; $i < count($xGenres); $i++){
            $sum .= " + AVG(IFNULL(" . $xGenres[$i] . ", 2.75))/$genreCount";
        }

        $xTags = explode(",", $tags[0]);
        if (count($xTags) > 0){
            $xTagsStr = "'" . $xTags[0] . "'";
            for ($i = 1; $i < count($xTags); $i++){
                $xTagsStr .= " or " . "'" . $xTags[$i] . "'";
            }
        }
        $sum .= " + SUM(IFNULL((tags = " . $xTagsStr . ")/5, 0))";

        //old method wasn't working, played around with executing queries directly until single SQL query reached.
        $sql = "SELECT Users.userId AS Id, ($sum) AS score FROM Users LEFT JOIN Tags ON Users.userId = Tags.userId GROUP BY Users.userId ORDER BY score DESC";
        //echo $sql;
        $result = $conn->query($sql);
        
        $gte4 = 0;//>=4
        $gtem = 0;//>=2.75 (the midpoint)
        $other = 0;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                if ($row["score"] >= 4){
                    $gte4++;
                }
                else if ($row["score"] >= 2.75){
                    $gtem++;
                }
                else{
                    $other++;
                }
            }
        }
        
        $total = $gte4 + $gtem + $other;
        if ($total > 0){
            $report = $gte4 . " users (" . (int)(100 * ($gte4/$total)) . "%) expected to really like it, ";
            $report .= $gtem . " users (" . (int)(100 * ($gtem/$total)) . "%) expected to quite like it, ";
            $report .= $other . " users (" . (int)(100 * ($other/$total)) . "%) expected to be indifferent.";
        }
        else{
            $report = "No data found regarding user preferences";
        }
        echo "test";
        //echo "\n\n\n" . $report;

        /*
        $sql = "SELECT userId, $xGenresStr AS userGenreRatings
        FROM Users
        ORDER BY userGenreRatings DESC";
        //echo $sql;
        //$result = $conn->query($sql);
        //$row = mysqli_fetch_fields($result);//combined average for each genre
        //this just takes into account genre, need to look at
        //tags and possibly number of films that contributed to genre ratings
        $xTagsStr = "'" . $xTags[0] . "'";//
        for ($i = 1; $i < count($xTags); $i++){
            $xTagsStr .= " or " . "'" . $xTags[$i] . "'";
        }
        $xTagsStr .= " GROUP BY userId";
        $tagsSql = "SELECT userId, COUNT(userId)/10 FROM Tags WHERE tags = $xTagsStr";
        echo $tagsSql;
        //$tagResult = $conn->query($tagsSql);
        */


        //$conn->close();
?>
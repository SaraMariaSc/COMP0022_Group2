<?php
    //fill out with connection params
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "example";
    $db = "MovieDB";
    $conn = new mysqli("db", "root", "example", "MovieDB") or die("Connect failed: %s\n". $conn -> error);

   
?>
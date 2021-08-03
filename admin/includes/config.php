<?php

//connect with PDO =>php data object

$servername = "localhost";
$dst = "mysql:host=$servername;dbname=ecommerce52";
$username = "root";
$password = "";

try {
    $connection = new PDO($dst,$username,$password);
    // echo "database is connected successfully";
} catch (PDOException $error) {
    echo $error->getMessage();
}

?>
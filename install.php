<?php declare(strict_types = 1);

require "config/database.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options); 
    $sql = file_get_contents("data/init.sql");  
    $connection->exec($sql);

    echo "Success!<br/><br/>";
    echo "&#9989; Database: sprint2_crud created <br/>";
    echo "&#9989; Table employees created<br/>";
    echo "&#9989; Table projects created<br/>";
    echo "&#9989; Table project_employee created<br/><br/>";
    echo "&#9989; Table employees seeded<br/>";
    echo "&#9989; Table projects seeded<br/>";
    echo "&#9989; Table project_employee seeded<br/><br/>";
    echo "<a href='/'>Go to main page</a>";


} catch(PDOException $error) {
    // echo $sql . "<br>" . $error->getMessage();
    echo "Failure <br/>";
    echo "Remove sprint2 database if it exist<br/>";
    echo "<a href='/'>Go to main page</a>";
}

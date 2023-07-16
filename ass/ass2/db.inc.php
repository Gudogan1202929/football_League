<?php


    // $servername = "localhost";
    // $username = "root";
    // $pass = "";
    // $db = "ass2";


    $host = "localhost";
    $username = "c104mosleh";
    $pass = "123456789";
    $db ="c104ass2";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
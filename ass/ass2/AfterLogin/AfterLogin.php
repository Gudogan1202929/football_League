<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

// connect to the database
require "../db.inc.php";

// get the user with the given id
$sql = "SELECT * FROM users WHERE UserID = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// if the user does not exist, redirect them to the login page
if (!$user) {
    header("Location: ../Login/login.php");
    exit;
}

//if the user didnt create a profile, redirect them to the profile creation page
$sql = "SELECT * FROM userprofiles WHERE UserID = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $_SESSION['user_id']]);
$profile = $stmt->fetch();

if (!$profile) {
    header("Location: ../User_Profile/profile.php");
    exit;
}






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellcome</title>
</head>
    <body>

        <header>
            <h3>web programming community of practice</h3>
        </header>

    <nav>
        <ul>
            <li><a href="../Knowladge/knowledge.php">knowledge base</a></li>
            <li><a href="../Sharing/FileSharing.php">share files</a></li>
            <li><a href="../Search/Search.php">Search</a></li>

            <li><a href="../Login/logout.php">logout</a></li>
        </ul>
    </nav>

    <hr/>

    <main>
        <img src="../images/png-transparent-infographics-a-practical-guide-for-librarians-meeting-community-needs-a-practical-guide-for-librarians-information-ppt-material-infographic-png-material-text-thumbnail.png" alt="web programming community of practice" width="500" height="300">
    </main>

    <hr/>

    <footer>
        <p>web programming community of practice &copy; 2021</p>
    </footer>


    </body>
</html>
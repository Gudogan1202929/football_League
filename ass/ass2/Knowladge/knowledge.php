<?php


//check if the user is logged in
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

//if the user didnt create a profile, redirect them to the profile creation page
require_once "../db.inc.php";
$sql = "SELECT * FROM userprofiles WHERE UserID = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $_SESSION['user_id']]);
$profile = $stmt->fetch();

if (!$profile) {
    header("Location: ../User_Profile/profile.php");
    exit;
}

//if the form was submitted
if (isset($_POST['create'])) {

    //boolean to check if the form is valid
    $valid = true;
    $isThereImage = false;
    $isThereVideo = false;

    //get the form data and trim the whitespace
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $keywords = trim($_POST['keywords']);
    $body = trim($_POST['body']);

    //upload the image
    $image = $_FILES['image'];

    //if there is an image
    if ($image['name'] != "") {
        $isThereImage = true;
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_new_name =  "_". time() ."_". $_SESSION['user_id']."_". $image_name;
        $image_error = $image['error'];

        if ($image_error == 0) {
            $image_destination = "../uploads/img/" . $image_new_name;
            move_uploaded_file($image_tmp_name, $image_destination);
        }else {
            $valid = false;
        }
    }

    

    //upload the video
    $video = $_FILES['video'];

    //if there is a video
    if ($video['name'] != "") {
        $isThereVideo = true;
        $video_name = $video['name'];
        $video_tmp_name = $video['tmp_name'];
        $video_new_name =  "_". time() ."_". $_SESSION['user_id']."_". $video_name;
        $video_error = $video['error'];

        if ($video_error == 0) {
            $video_destination = "../uploads/video/" . $video_new_name;
            move_uploaded_file($video_tmp_name, $video_destination);
        }else {
            $valid = false;
        }
    }


    //if the form is valid
    if ($valid) {

        //insert the article into the database if there is no image or video set the value to null
        if ($isThereImage && $isThereVideo) {
            $sql = "INSERT INTO knowledgebase (Title, Description, Keywords, Body, Image, Video, UserID) VALUES (:title, :description, :keywords, :body, :image, :video, :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['title' => $title, 'description' => $description, 'keywords' => $keywords, 'body' => $body, 'image' => $image_new_name, 'video' => $video_new_name, 'id' => $_SESSION['user_id']]);
        }elseif ($isThereImage) {
            $sql = "INSERT INTO knowledgebase (Title, Description, Keywords, Body, Image, Video, UserID) VALUES (:title, :description, :keywords, :body, :image, NULL, :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['title' => $title, 'description' => $description, 'keywords' => $keywords, 'body' => $body, 'image' => $image_new_name, 'id' => $_SESSION['user_id']]);
        }elseif ($isThereVideo) {
            $sql = "INSERT INTO knowledgebase (Title, Description, Keywords, Body, Image, Video, UserID) VALUES (:title, :description, :keywords, :body, NULL, :video, :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['title' => $title, 'description' => $description, 'keywords' => $keywords, 'body' => $body, 'video' => $video_new_name, 'id' => $_SESSION['user_id']]);
        }else {
            $sql = "INSERT INTO knowledgebase (Title, Description, Keywords, Body, Image, Video, UserID) VALUES (:title, :description, :keywords, :body, NULL, NULL, :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['title' => $title, 'description' => $description, 'keywords' => $keywords, 'body' => $body, 'id' => $_SESSION['user_id']]);
            
        }


        //redirect the user to the knowledge base
        header("Location: ../Knowladge/knowledge.php");
        exit;
    }



}






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>knowledge base</title>
</head>
<body>

    <header>
        <h3>knowledge base</h3>
    </header>

    <nav>
        <p>you can here create article</p>
    </nav>

    <hr>

    <main>
        <img src="../images/MM copy.png" alt="pic"/>

        <form action="" method="post" enctype="multipart/form-data">
            Title: <input type="text" name="title" required><br>
            Description: <textarea name="description" required></textarea><br>
            Keywords: <input type="text" name="keywords"><br>
            Body: <textarea name="body" required></textarea><br>
            Image: <input type="file" name="image" accept="image/png, image/jpeg, image/gif"><br>
            Video: <input type="file" name="video"><br>
            <input type="submit" value="Create Article" name="create">
        </form>
    </main>

    <footer>
        <p>web programming community of practice &copy; 2021</p>
    </footer>
    
</body>
</html>
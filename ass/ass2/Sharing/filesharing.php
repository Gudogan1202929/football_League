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
    if (isset($_POST['upload'])) {

        $valid = true;

        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $keywords = trim($_POST['keywords']);
        
        //upload the file
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_new_name =  "_". time() ."_". $_SESSION['user_id']."_". $file_name;
        $file_error = $file['error'];

        if ($file_error == 0) {
            $file_destination = "../uploads/files/" . $file_new_name;
            move_uploaded_file($file_tmp_name, $file_destination);
        }else {
            $valid = false;
        }

        //if the form is valid, insert the data into the database
        if ($valid) {
            $sql = "INSERT INTO files (Title, Description, Keywords, FilePlace, UserID) VALUES (:title, :description, :keywords, :file, :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['title' => $title, 'description' => $description, 'keywords' => $keywords, 'file' => $file_new_name, 'id' => $_SESSION['user_id']]);
            header("Location: ../Sharing/filesharing.php");
            exit;
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Sharing</title>
</head>
    <body>
        <header>
            <h3>you can Sharing the files her</h3>
        </header>

        <hr/>

        <img src="../images/MM copy.png">

        <hr/>
        <body>
            <form action="" method="post" enctype="multipart/form-data">
                Title: <input type="text" name="title" required><br>
                Description: <textarea name="description" required></textarea><br>
                Keywords: <input type="text" name="keywords"><br>
                File: <input type="file" name="file" required><br>
                <input type="submit" value="Upload File" name="upload">
            </form>
        </body>

        <hr/>

        <footer>
            <p>web programming community of practice &copy; 2021</p>
        </footer>
    </body>
</html>
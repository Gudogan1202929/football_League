
<?php
    //check if the user is logged in
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../Login/login.php");
        exit;
    }

    //check if the user has already created a profile
    require_once "../db.inc.php";
    $sql = "SELECT * FROM userprofiles WHERE UserID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $profile = $stmt->fetch();

    if ($profile) {
        header("Location: ../AfterLogin/AfterLogin.php");
        exit;
    }

    //if the form was submitted
    if (isset($_POST['create'])) {

        //boolean to check if the form is valid
        $valid = true;


        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $area_of_experience = $_POST['area_of_experience'];
        $level_of_experience = $_POST['level_of_experience'];
        $area_of_interest = $_POST['area_of_interest'];

        //upload the photo
        $photo = $_FILES['photo'];
        $photo_name = $photo['name'];
        $photo_tmp_name = $photo['tmp_name'];
        $photo_new_name =  "_". time() ."_". $_SESSION['user_id']."_". $photo_name;
        $photo_error = $photo['error'];

        if ($photo_error == 0) {
            $photo_destination = "../uploads/img/" . $photo_new_name;
            move_uploaded_file($photo_tmp_name, $photo_destination);
        }else {
            $valid = false;
        }

        //upload the cv
        $cv = $_FILES['cv'];
        $cv_name = $cv['name'];
        $cv_tmp_name = $cv['tmp_name'];
        $cv_error = $cv['error'];

        if ($cv_error == 0) {
            $cv_destination = "../uploads/cv/" . $cv_name;
            move_uploaded_file($cv_tmp_name, $cv_destination);
        }else {
            $valid = false;
        }


        //insert the profile into the database
        if($valid){
            $sql = "INSERT INTO userprofiles (Name, Photo, Bio, CV, AreaOfExperience, ExperienceLevel,AreaOfInterest, UserID) VALUES (:name, :photo, :bio, :cv, :area_of_experience, :level_of_experience,:AreaOfInterest, :user_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'photo' => $photo_destination, 'bio' => $bio, 'cv' => $cv_destination, 'area_of_experience' => $area_of_experience, 'level_of_experience' => $level_of_experience, 'AreaOfInterest' =>$area_of_interest ,'user_id' => $_SESSION['user_id']]);
        }else {
            header("Location: profile.php?error=Invalid data");
            exit;
        }

        //redirect to the welcome page
        header("Location: ../AfterLogin/AfterLogin.php");
    }




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile </title>
</head>
    <body>
        <header>
            <h3>Please Create profile</h3>
        </header>

        <hr/>
        <img src="../images/MM copy.png">
        <hr/>

        <body>

            <h1>Create Profile</h1>
            <?php
                if (isset($_GET['error'])) {
                    echo "<p>".$_GET['error']."</p>";
                }
            ?>
            
            <form action="profile.php" method="post" enctype="multipart/form-data">
                Name: <input type="text" name="name" required><br>
                Photo: <input type="file" name="photo" accept="image/png, image/jpg, image/gif"><br>
                Bio: <textarea name="bio"></textarea><br>
                CV: <input type="file" name="cv" accept="application/pdf"><br>
                Area of experience: <input type="text" name="area_of_experience"><br>
                Level of experience: 
                <select name="level_of_experience">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                    <option value="expert">Expert</option>
                </select><br>
                Area of interest: <input type="text" name="area_of_interest"><br>
                <input type="submit" value="Create Profile" name="create">
            </form>
        </body>

        <hr/>

        <footer>
            <p>web programming community of practice &copy; 2021</p>
        </footer>
    </body>
</html>
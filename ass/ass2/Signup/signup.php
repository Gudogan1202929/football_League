<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../AfterLogin/AfterLogin.php");
    exit;
}

// if the signup form was submitted

if (isset($_POST['signup'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //if password is less than 8 characters
    if (strlen($password) < 8) {
        header("Location: ../Signup/signup.php?error=Password must be at least 8 characters");
        exit;
    }   

    // connect to the database
    require "../db.inc.php";

    //check if the email is already in the database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        header("Location: ../Signup/signup.php?error=Email already exists");
        exit;
    }

    

    // insert the new user into the database
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);

    // redirect to the login page
    header("Location: ../Login/login.php");

    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
    <body>
        <header>
            <h3>Please Sign up</h3>
        </header>

        <hr/>

        <img src="../images/MM copy.png">

        <hr/>
        <body>
            <?php
                // if there are any errors, display them
                if (isset($_GET['error'])) {
                    echo "<p>".$_GET['error']."</p>";
                }
            
            ?>

            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <input type="submit" value="Sign Up" name="signup">
            </form>

        </body>

        <hr/>

        <footer>
            <p>web programming community of practice &copy; 2021</p>
        </footer>
    </body>
</html>
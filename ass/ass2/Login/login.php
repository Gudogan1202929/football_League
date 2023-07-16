
<?php
include '../db.inc.php';
session_start();

// if the user is already logged in, then redirect them to the welcome page
if (isset($_SESSION['user_id'])) {
    header("Location: ../AfterLogin/AfterLogin.php");
    exit;
}

// if the login form was submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION["user_id"] = $user["UserID"];
        header("Location: ../User_Profile/profile.php");
    } else {
        header("Location: ../Login/login.php?error=Invalid email or password");
    }
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>

<header>
    <h1>Log In page</h1>
</header>

<nav>
    <p>wellcome to my website programming community of practice</p>
</nav>

<hr/>

<img src="../images/MM copy.png" alt="pic"/>

<hr/>

<main>

    <?php if (isset($_GET['error'])) { ?>
        <p><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Log In" name="login">
    </form>
</main>

<hr/>

<footer>
    <p>Programming Community of Practice</p>
</footer>

    
</body>
</html>
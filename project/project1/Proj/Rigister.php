<?php
include "../conn.php";

session_start();

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(strlen($password) < 8){
        header("Location: ../index.php?error-message=Password must be at least 8 characters&errNum=2");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        header("Location: ../index.php?error-message=Email already exists&errNum=3");
        exit;
    }

    if($password !== $confirm_password){
        header("Location: ../index.php?error-message=Password confirmation does not match&errNum=4");
        exit;
    }

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $user_name);
    $stmt->bindValue(2, $email);
    $stmt->bindValue(3, $password);
    $stmt->execute();

    header("Location: ../index.php?errNum=0");
?>
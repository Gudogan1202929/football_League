<?php
include "../conn.php";

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$user = $stmt->fetch();

if ($user && $user['password'] === $password) {
    $_SESSION["user_id"] = $user["id"];
    header("Location: KickballLeagueDash.php");
} else {
    header("Location: ../index.php?error-message=Invalid email or password&errNum=1");
}
?>
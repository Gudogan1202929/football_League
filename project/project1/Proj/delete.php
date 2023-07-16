<?php
include "../conn.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

$TeamName = $_GET['team_name'];

$sql = "DELETE FROM players WHERE team_id IN (SELECT id FROM teams WHERE team_name = :TeamName)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':TeamName', $TeamName);
$stmt->execute();

$sql = "DELETE FROM teams WHERE team_name = :TeamName";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':TeamName', $TeamName);
$stmt->execute();

header("Location: KickballLeagueDash.php");
exit();
?>
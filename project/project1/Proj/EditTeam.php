<?php
include "../conn.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TeamName = $_POST['TeamName'];
    $SkillLevel = $_POST['SkillLevel'];
    $GameDay = $_POST['GameDay'];

    if ($SkillLevel < 1 || $SkillLevel > 5) {
        header("Location: EditTeam.php?error-message=Skill level must be a number between 1 and 5&team_name=$TeamName");
        exit();
    }

    $TeamNameFromGet = $_GET['team_name'];

    $sql = "SELECT id FROM teams WHERE team_name = :TeamNameFromGet";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':TeamNameFromGet', $TeamNameFromGet);
    $stmt->execute();
    $team = $stmt->fetch();

    $teamId = $team['id'];

    $sql = "UPDATE teams SET team_name = :teamName, skill_level = :skillLevel, game_day = :gameDay WHERE id = :teamId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':teamName', $TeamName);
    $stmt->bindValue(':skillLevel', $SkillLevel);
    $stmt->bindValue(':gameDay', $GameDay);
    $stmt->bindValue(':teamId', $teamId);
    $stmt->execute();

    header('Location: KickballLeagueDash.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="Style/EditTeamStyle.css">

    
    <title>Edit Team</title>
</head>
<body>

<header>
    
    <img src="../imges/img.jpg" alt="logo" class ="logo">
    
    <div>
        <h1>kickball League</h1>
        <a href="AboutUs.html">About us</a>
    </div>
       
    
    <div>
        <figure>
            <img src="../imges/user.jpg" alt="acc"  class ="imguser">
            <?php 
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT username FROM users WHERE id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            $user = $stmt->fetch();

            echo "<figcaption>" . $user['username'] . "</figcaption>";
            ?>
        </figure>

        <a href="logout.php">Log Out</a>
   </div>


    </header>


<div id="maindiv">

<nav>
    <ul>
        <li><a href="KickballLeagueDash.php">Dash board</a></li>
    </ul>
</nav>

<main>
<?php

    $TeamName = $_GET['team_name'];

    $sql = "SELECT * FROM teams WHERE team_name = :TeamName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':TeamName', $TeamName);
    $stmt->execute();
    $article = $stmt->fetch();
?>

    <table class="table" >
        <form action="" method="post">

            <tr>
                <th colspan="2">Edit Team</th>
            </tr>

            <tr>
                <td>Team Name :</td>
                <td><input type="text" name="TeamName" id="TeamName" value ="<?php
                        echo $article['team_name'];
                ?>" required>
                
                </td>
            </tr>
            <tr>
                <td>Skill Level :</td>
                <td><input type="text" name="SkillLevel" id="SkillLevel" value = "<?php
                        echo $article['skill_level'];
                ?>" required>

            </td>
            </tr>
            <tr>
                <td>Game Day :</td>
                <td><input type="text" name="GameDay" id="GameDay" value ="<?php
                        echo $article['game_day'];
                ?>" required>

            </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Edit"  class="submit"></td>
            </tr>
        </form>
    </table>
    <?php 
            if(isset($_GET["error-message"])){
                echo'<h4>' . $_GET["error-message"] . '</h4>';
            }
        ?>
</main>

</div>

<footer>
    <img src="../imges/img.jpg" alt="logo" class="logo"/>
    <ul>
        <li>Contact us :</li>
        <li><a href="https://myaccount.google.com/?hl=ar">Email: mohammadnmosleh123@gmail.com</a></li>
        <li><a href=""></a>Tel: 0597190708</li>
        <li><a href="https://www.google.com/search?q=ramallah+alnatsha&oq=ramallah+alnatsha&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIJCAEQIRgKGKABMgkIAhAhGAoYoAEyCQgDECEYChigATIJCAQQIRgKGKABMgkIBRAhGAoYoAHSAQ45NjEwMDUwOTBqMGoxNagCALACAA&sourceid=chrome&ie=UTF-8">Location: Ramallah</a></li>
    </ul>
    <p>web programming community of practice &copy; 2021</p>
</footer>

</body>

</html>
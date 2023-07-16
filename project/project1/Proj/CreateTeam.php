<?php
include "../conn.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $teamName = $_POST['TeamName'];
        $skillLevel = $_POST['SkillLevel'];
        $gameDay = $_POST['GameDay'];

        if ($skillLevel < 1 || $skillLevel > 5) {
            header("Location: CreateTeam.php?error-message=Skill level must be a number between 1 and 5");
            exit();
        }
      
        $stmt = $pdo->prepare("INSERT INTO teams (team_name, skill_level, game_day ,user_id) VALUES (?, ?, ?,?)");
        $stmt->bindValue(1, $teamName);
        $stmt->bindValue(2, $skillLevel);
        $stmt->bindValue(3, $gameDay);
        $stmt->bindValue(4, $_SESSION['user_id']);
        $stmt->execute();

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT username FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch();

        $sql = "SELECT id FROM teams WHERE team_name = :team_name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':team_name', $teamName);
        $stmt->execute();
        $team = $stmt->fetch();

        // add the user to the team as a player
        $stmt = $pdo->prepare("INSERT INTO players (player_name, team_id) VALUES (?, ?)");
        $stmt->bindValue(1, $user['username']);
        $stmt->bindValue(2, $team['id']);
        $stmt->execute();


      if ($stmt->rowCount() > 0) {
        header('Location: KickballLeagueDash.php');
        exit();
      } else {
        header("Location: CreateTeam.php?error-message=Error creating team");
        exit();
      }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new team</title>
    <link rel="stylesheet" href="Style/CreateTeamStyle.css">
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

        <h1>Create new team</h1>

    <table class="table">
            <form action="" method="post">
                <tr>
                    <th colspan="2" id="tableHeder">Create Team</th>
                </tr>
                <tr >
                    <td>Team Name :</td>
                    <td><input type="text" name="TeamName" id="TeamName" required></td>
                </tr>
                <tr>
                    <td>Skill Level :</td>
                    <td><input type="text" name="SkillLevel" id="SkillLevel" required></td>
                </tr>
                <tr>
                    <td>Game Day :</td>
                    <td><input type="text" name="GameDay" id="GameDay" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Create team"  class="submit"></td>
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
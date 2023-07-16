<?php
include "../conn.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerName = $_POST['Player_Name'];
    $teamName = $_GET['team_name'];

    $sql = "SELECT id FROM teams WHERE team_name = :team_name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':team_name', $teamName);
    $stmt->execute();
    $team = $stmt->fetch();

    $teamId = $team['id'];

    $sql = "SELECT COUNT(*) AS num_players FROM players WHERE team_id = :team_id GROUP BY team_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':team_id', $teamId);
    $stmt->execute();
    $playerCount = $stmt->fetchColumn();

    if ($playerCount >= 9) {
        header("Location: TeamDitails.php?error-message=Team is full&team_name=" . $teamName);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO players (player_name, team_id) VALUES (?, ?)");
    //with bindValue
    $stmt->bindValue(1, $playerName);
    $stmt->bindValue(2, $teamId);
    $stmt->execute();

    header('Location: KickballLeagueDash.php?team_name=' . $teamName);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details</title>
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
        <li><a href="KickballLeagueDash.php">Dashboard</a></li>

        <?php
            $Team_name = $_GET['team_name'];

            $sql = "SELECT user_id FROM teams WHERE team_name = :team_name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':team_name', $Team_name);
            $stmt->execute();
            $article = $stmt->fetch();

            if ($article['user_id'] == $_SESSION['user_id']) {

                echo "<li><a href='EditTeam.php?team_name=" . $Team_name . "'>Edit</a></li>";
                echo "<li><a href='delete.php?team_name=" . $Team_name . "'>Delete</a></li>";
            }
        ?>

    </ul>

    </nav>


    <main>
        
    <table class="table1">


                <?php
                $Team_name = $_GET['team_name'];
                $sql = "SELECT * FROM teams WHERE team_name = :team_name";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':team_name', $Team_name);
                $stmt->execute();
                $article = $stmt->fetch();

                echo "<h1>" . $article['team_name'] . "</h1>";


                ?>

                <tr >
                    <td>Team Name :</td>
                    <td>
                        <?php
                        echo $article['team_name'];
                        ?>

                    </td>
                </tr>
                <tr>
                    <td>Skill Level :</td>
                    <td>
                        <?php
                        echo $article['skill_level'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Game Day :</td>
                    <td>
                        <?php
                        echo $article['game_day'];
                        ?>
                    </td>
                </tr>
        </table>

        <?php 
            $Team_name = $_GET['team_name'];
            $sql = "SELECT player_name FROM players, teams WHERE players.team_id = teams.id AND team_name = :team_name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':team_name', $Team_name);
            $stmt->execute();
            $articles = $stmt->fetchAll();

            echo "<h1>Team Members</h1>";
            echo "<table class='table'>";
            echo "<tr>";
            foreach ($articles as $article) {
                echo '<td>' . $article['player_name'] . '</td>';
            }
            echo "</tr>";
            echo "</table>";
        ?>




        <?php
            $Team_name = $_GET['team_name'];

            $sql = "SELECT user_id FROM teams WHERE team_name = :team_name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':team_name', $Team_name);
            $stmt->execute();
            $article = $stmt->fetch();

            if ($article['user_id'] == $_SESSION['user_id']) {

                echo "<h1>Add Player :</h1>";

                echo "<table class='table' border='1'>";
                echo    '<form action="" method="post">';
                echo        '<tr>';
                echo           "<td>Player Name :</td>";
                echo           '<td><input type="text" name="Player_Name" id="Player_Name" required></td>';
                echo      " </tr>";
                echo       "<tr>";
                echo            '<td colspan="2"><input type="submit" value="Add" class="submit"></td>';
                echo        "</tr>";
                echo   "</form>";
                echo "</table>";
            }
        ?>
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
    <p>web programming community of practice &copy; 2021</p>    </footer>
</body>
</html>
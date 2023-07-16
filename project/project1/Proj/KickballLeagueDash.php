<?php
include "../conn.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kickball League Dashboard</title>
    <link rel="stylesheet" href="Style/StyleDash.css">
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
            <li><a href="CreateTeam.php">Create New Team</a></li>
        </ul>
    </nav>

    <main>

    <section>
    <h1>wellcome <?php 
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT username FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch();
        echo $user['username'];
        ?></h1>
    </section>

    <table class="table">
        <tr>
            <th>Team Name</th>
            <th>Skill Level (1-5)</th>
            <th>Players (1-9)</th>
            <th>Game Day</th>
        </tr>

        <?php
                $sql = "SELECT team_name, skill_level, COUNT(players.id) AS num_players, game_day
                from teams, players
                where teams.id = players.team_id
                group by teams.id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $articles = $stmt->fetchAll();
                foreach ($articles as $article) {
                    echo "<tr id='tableHeder'>";
                    echo "<td><a href='TeamDitails.php?team_name=" . $article['team_name'] . "'>" .  $article['team_name']."</a></td>";
                    echo "<td>" . $article['skill_level'] . "</td>";
                    echo "<td>" . $article['num_players'] . "</td>";
                    echo "<td>" . $article['game_day'] . "</td>";
                    echo "</tr>";
                }
        ?>
        </table>
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
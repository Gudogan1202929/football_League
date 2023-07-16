<html>

<head>
    <title>Article INfo</title>
</head>

<body>

    <header>
        <h1>Article Info</h1>
    </header>

    <?php

        include "../db.inc.php";
        //show the article info with binding parameters
        $article_id = $_GET['article_id'];
        $sql = "SELECT * FROM knowledgebase WHERE ArticleID = :article_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':article_id', $article_id);
        $stmt->execute();
        $article = $stmt->fetch();

        echo "<h2>Title: " . $article['Title'] . "</h2>";
        echo "<p>Description: " . $article['Description'] . "</p>";
        echo "<p>Keywords : " . $article['Keywords'] . "</p>";

        //get the author name from the users table
        $sql = "SELECT * FROM userprofiles WHERE UserID = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $article['UserID']);
        $stmt->execute();
        $user = $stmt->fetch();
        echo "<p>Author: " . $user['Name'] . "</p>";

        //show the body of the article
        echo "<p>Body :" . $article['Body'] . "</p>";

        //show if there is a image or video
        if ($article['Image'] != "") {
            echo "<img src='../uploads/img/" . $article['Image'] . "' />";
        }

        if ($article['Video'] != "") {
            echo "<video controls>";
            echo "<source src='../uploads/video/" . $article['Video'] . "' type='video/mp4'>";
            echo "</video>";
        }


    ?>
    




</html>
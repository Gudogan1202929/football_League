


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>

<header>
    <h1>Search</h1>
</header>

<nav>
    <p>wellcome to my website programming community of practice 
        you can search here ...
    </p>
</nav>

<hr/>

<img src="../images/MM copy.png" alt="pic"/>

<hr/>

<main>
    <form action="" method="post">
        Search: <input type="text" name="search" required><br>
        <input type="submit" value="Search" name="searchA">
    </form>


    <table>
        <tr>
            <th>File Name</th>
            <th>File Description</th>
            <th>File Keywords</th>
            <th>File Owner</th>
        </tr>
        <?php
            include "../db.inc.php";

            if (isset($_POST['searchA'])) {
                $search = $_POST['search'];
                $sql = "SELECT * FROM files WHERE Title LIKE '%$search%' OR Description LIKE '%$search%' OR Keywords LIKE '%$search%'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $files = $stmt->fetchAll();
                foreach ($files as $file) {
                    echo "<tr>";
                    echo "<td>" . $file['Title'] . "</td>";
                    echo "<td>" . $file['Description'] . "</td>";
                    echo "<td>" . $file['Keywords'] . "</td>";
                    // get the author name from the users table
                    $sql = "SELECT * FROM userprofiles WHERE UserID = " . $file['UserID'];
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $user = $stmt->fetch();
                    echo "<td>" . $user['Name'] . "</td>";

                    echo "</tr>";
                }
            }
        ?>

        


        <tr>
            <th>Article Name</th>
            <th>Article keywords</th>
            <th>Article Description</th>
            <th>Article author</th>

        </tr>

        <?php
            if (isset($_POST['searchA'])) {
                $search = $_POST['search'];
                $sql = "SELECT * FROM knowledgebase WHERE Title LIKE '%$search%' OR Description LIKE '%$search%' OR Keywords LIKE '%$search%'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $articles = $stmt->fetchAll();
                foreach ($articles as $article) {
                    echo "<tr>";
                    //make the article name clickable to go to the article page
                    echo "<td><a href='article.php?article_id=" . $article['ArticleID'] . "'>" . $article['Title'] . "</a></td>";
                    echo "<td>" . $article['Keywords'] . "</td>";
                    echo "<td>" . $article['Description'] . "</td>";
                    //get the author name from the users table
                    $sql = "SELECT * FROM userprofiles WHERE UserID = " . $article['UserID'];
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $user = $stmt->fetch();
                    echo "<td>" . $user['Name'] . "</td>";
                    echo "</tr>";
                }


            }
        ?>

    </table>


</main>

<hr/>

<footer>
    <p>Programming Community of Practice</p>
</footer>
    
</body>
</html>
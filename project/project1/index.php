<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kickball league</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="imges/img.jpg" alt="logo" class ="logo">
    <div>
        <h1>kickball League</h1>
        <a href="/Proj/AboutUs.html">About us</a>
    </div>
</header>
<div id="maindiv">
<nav>
    <ul>
        Contact us :
        <li><a href="/Proj/AboutUs.html">About us</a></li>
    </ul>
</nav>

<main>

    <section>


        <table class="table"  border="1">
            <form action="Proj/login.php" method="post">

                <tr id="tableHeder">
                    <th colspan="2"><label id="label1">Login</label></th>
                </tr>
                <tr>
                    <td><label id="label2">Email :</label></td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><label id="label3">Password :</label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="login" class="submit"></td>
                </tr>
            </form>
        </table>

        <?php 
            if(isset($_GET["error-message"])){
                if($_GET['errNum'] == 1){
                    echo'<h4>' . $_GET["error-message"] . '</h4>';
                }
            }
        ?>


    </section>

    
    <section>


        <table class="table"  border="1">
            <form action="Proj/Rigister.php" method="post">

                <tr id="tableHeder">
                    <th colspan="2">Register</th>
                </tr>

                <tr>
                    <td>User Name :</td>
                    <td><input type="text" name="user_name" id="user_name" required></td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td>Password :</td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td>Confirm Password :</td>
                    <td><input type="password" name="confirm_password" id="confirm_password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="signup" class="submit"></td>
                </tr>
            </form>
        </table>

        <?php
            if(isset($_GET["error-message"])){
                if ($_GET['errNum'] > 1) {
                    echo'<h4>' . $_GET["error-message"] . '</h4>';
                }
            }
        ?>

    </section>


</main>

</div>
<footer>
    <img src="imges/img.jpg" alt="logo" class="logo"/>
    <ul>
        <li>Contact us :</li>
        <li><a href="https://myaccount.google.com/?hl=ar">Email: mohammadnmosleh123@gmail.com</a></li>
        <li><a href=""></a>Tel: 0597190708</li>
        <li><a href="https://www.google.com/search?q=ramallah+alnatsha&oq=ramallah+alnatsha&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIJCAEQIRgKGKABMgkIAhAhGAoYoAEyCQgDECEYChigATIJCAQQIRgKGKABMgkIBRAhGAoYoAHSAQ45NjEwMDUwOTBqMGoxNagCALACAA&sourceid=chrome&ie=UTF-8">Location: Ramallah</a></li>
    </ul>
    <p>web programming community of practice &copy; 2021</p>
</footer>
</body>
    
</body>
</html>
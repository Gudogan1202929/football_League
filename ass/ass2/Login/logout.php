<?php

//logout the user
session_start();
session_unset();
session_destroy();
header("Location: ../Login/login.php");
exit;
?>


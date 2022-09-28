<?php 
session_start() 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <h1>Homepage</h1>
    <?= $_SESSION && $_SESSION['user'] ?  $_SESSION['user']['email'] : 'guest' ?>
    <br>
    <?= $_SESSION['user']['credit'] ?>
</body>
</html>
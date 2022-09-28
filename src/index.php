<?php 
session_start() 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./includes/head.php') ?>
    <title>MyDigitalSucre</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <h1>Accueil</h1>
    <?= $_SESSION && $_SESSION['user'] ?  $_SESSION['user']['email'] : 'guest' ?>
    <br>
    <?= $_SESSION['user']['credit'] ?>
</body>
</html>
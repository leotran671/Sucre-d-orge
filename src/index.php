<?php 
session_start() 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./includes/head.php') ?>
    <link rel="stylesheet" href="/public/style/index.css">
    <title>Accueil - My Digital Sucre</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <div id="backgroundImage">
    <h1>Bienvenue <?= $_SESSION && $_SESSION['user'] ?  $_SESSION['user']['email'] : 'guest' ?></h1>
    
    <br>
    <h3>Envoyez un message sucré à votre ami(e)</h3>
   <div class="buttons">
    <button><a href="./login.php">Connexion</a></button> <button > <a href="signin.php">S'inscrire</a></button>
   </div>
    </div>
    
</body>
</html>
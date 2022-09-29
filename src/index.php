<?php 
session_start() 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./includes/head.php') ?>
    <link rel="stylesheet" href="/public/style/index.css">
    <title>MyDigitalSucre</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <div id="backgroundImage">
    <h1>Bienvenue <?= $_SESSION && $_SESSION['user'] ?  $_SESSION['user']['email'] : 'guest' ?></h1>
    
    <br>
    <h3>Envoyez un message sucré à votre ami(e)</h3>
   <div class="buttons">
    <button>Connexion</button> <button>S'inscrire</button>

   </div>
    </div>
    
</body>
</html>
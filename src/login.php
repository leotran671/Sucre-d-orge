<?php
session_start();
require('./includes/db.php');
require('./includes/flash.php');

if($_SESSION && isset($_SESSION['user'])) header('Location: /');

/**
 * @param string $email
 * @param string $password
 * @return array
 */
function findUser($email, $password) {
    global $bdd;
    $query = $bdd->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
    $query->execute([
        'email' => $email,
        'password' => md5($password)
    ]);
    $user = $query->fetch();
    return $user;
}

/**
 * @return void
 */
function handlePost() {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = findUser($email, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: /');
        } else {
            return flash("Email ou mot de passe invalide");
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePost();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require('./includes/head.php') ?>
    <title>Inscription</title>
    <link rel="stylesheet" href="public/style/login.css">
</head>

<body>
    <?php require('./includes/nav.php') ?>
    <form method="POST">
        <div id="title">
            <h1>Connexion</h1>
        </div>

        <div class="input">
            <label for="mail">Email</label>              
            <input type="email" placeholder="Saisissez votre adresse e-mail" id="mail" name="email" value="<?= isset($mail) && $mail ?>" />
        </div>
            
        <div class="input">
            <label for="mdp">Mot de passe</label>
            <input type="password" placeholder="Saisissez votre mot de passe" id="mdp" name="password" />     
        </div>        
    
        <input id="submit" type="submit" value="Je me connecte" />              
    </form>

    <div class="alerts">
        <?php if(isset($_SESSION['flash'])): ?>
            <?php foreach($_SESSION['flash'] as $flash): ?>
                <?= "<div class='alert error'>{$flash}</div>" ?>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']) ?>
        <?php endif ?>
    </div>
</body>
</html>
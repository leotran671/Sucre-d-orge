<?php
session_start();
require('./includes/db.php');
require('./includes/flash.php');

if($_SESSION && isset($_SESSION['user'])) header('Location: /');

/**
 * @param string $email
 * @return boolean
 */
function findEmail($email) {
    global $bdd;
    $query = $bdd->prepare('SELECT * FROM users where email = ?');
    $query->execute(array($email));
    $emailExist = $query->rowCount();
    if($emailExist !== 0) {
        return true;
    }
    return false;
}

/**
 * @param string $password
 * @return string
 */
function hashPassword($password) {
    return md5($password);
}

/**
 * @return void
 */
function createUser() {
    global $bdd;
    $query = $bdd->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
    $query->execute([
        'email' => $_POST['email'],
        'password' => hashPassword($_POST['password'])
    ]);
}

/**
 * @return void
 */
function handlePost() {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_verif = $_POST['password_verif'];

        if($password !== $password_verif) { 
            return flash("Les mots de passe ne correspondent pas");
        }

        if(empty($email) || empty($password) || empty($password_verif)) {
            return flash("Tous les champs sont obligatoires");
        }

        if(!strpos($email,'@my-digital-school.org')){
            echo 'Vous devez utiliser une adresse mail MyDigitalSchool';
            return;
        }
        if(findEmail($email)==true){
            return flash("L'adresse mail est déjà dans la base de donnée");
        }
        createUser();
        header('Location: /login.php');
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
    <title>Inscription - My Digital School</title>
    <link rel="stylesheet" href="public/style/signin.css">
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <form method="POST">
        <div id="title">
            <h1>Inscrivez-vous avec votre adresse e-mail</h1>
        </div>

        <div class="input">
            <label for="mail">Quelle est votre adresse e-mail</label>              
            <input type="email" placeholder="Saisissez votre adresse e-mail" id="mail" name="email" value="<?= isset($mail) && $mail ?>" />
        </div>
            
        <div class="input">
            <label for="mdp">Créez votre mot de passe</label>
            <input type="password" placeholder="Saisissez votre mot de passe" id="mdp" name="password" />     
        </div>
    
        <div class="input">
            <label for="mdp_verif">Confirmez votre mot de passe</label>
            <input type="password" placeholder="Confirmez votre mot de passe" id="mdp_verif" name="password_verif" />
        </div>
                        
        <input id="submit" type="submit" value="Je m'inscris" />              
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
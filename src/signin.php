<?php
session_start();
require('./includes/db.php');

if($_SESSION && $_SESSION['user']) header('Location: /');

/**
 * @param string $email
 * @return boolean
 */
function findEmail($email) {
    global $bdd;
    $query = $bdd->prepare('SELECT * FROM users WHERE email = :email');
    $query->execute([
        'email' => $email
    ]);
    $emailExist = $query->rowCount();
    if($emailExist !== 0) {
        return "Email already exist";
    }

    if(!preg_match("/^([\w]*[\w\.]*(?!\.)@my-digital-school.org)/", $email)) {
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
            echo 'Passwords do not match'; 
            return;
        }

        if(empty($email) || empty($password) || empty($password_verif)) {
            echo 'Veuillez remplir tous les champs';
            return;
        }

        if(!strpos($email,'@my-digital-school.org')){
            echo 'Vous devez utiliser une adresse mail MyDigitalSchool';
            return;
        }

        if(findEmail($email)) {
            echo 'Cette adresse mail est déjà utilisée';
            return;
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
    <title>Inscription</title>
    <meta charset="utf-8">
    <link rel='stylesheet' href='public/style/backgroundSnow.css'>
    <link rel ='stylesheet' href='public/style/style.css'>
</head>
<body>

<div class="contenerSnow">
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
    <div class="snow"></div>
</div>

<div class="cursor"><img src="public/medias/sugarCane.png" width="25" height="30" alt="Sugar Cane"></div>
    <?php require('./includes/nav.php') ?>
    <form id="formularSuscribe" method="POST" action="">
        <div id="title"><h1>Inscrivez-vous avec votre adresse e-mail</h1></div>
                
                    <label for="mail">Quelle est votre adresse e-mail</label>    
                              
                    <input class="input" type="email" placeholder="Saisissez votre adresse e-mail" id="mail" name="email" value="
                    <?php if (isset($mail)) {
                        echo $mail;
                    } ?>" />
                       
                    <label for="mdp">Créez votre mot de passe</label>
               
                    <input class="input" type="password" placeholder="Saisissez votre mot de passe" id="mdp" name="password" />             
               
                    <label for="mdp2">Confirmez votre mot de passe</label>
                              
                    <input class="input"type="password" placeholder="Saisissez de nouveau votre mot de passe" id="mdp2" name="password_verif" />
                                  
                    <input id="submit" type="submit" value="Je m'inscris" />
                    <p id="test"></p>
              
    </form>
    <?php
    if (isset($erreur_mdp)) {
        echo '<font color="red">' . $erreur_mdp;
    } elseif (isset($erreur)) {
        echo '<font color="red">' . $erreur;
    }
    ?>

    <script>
    const cursor = document.querySelector('.cursor');
    document.addEventListener('mousemove',e=>{
    cursor.setAttribute('style','top:'+(e.pageY-4)+"px; left:"+(e.pageX-10)+"px;")
})
</script>
</body>
</html>
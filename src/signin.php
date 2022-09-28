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

        if(!strpos($email,'my-digital-school.org')){
            echo 'Vous devez une adresse mail de MyDigitalSchool';
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
</head>

<body>
<<<<<<< HEAD

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
=======
>>>>>>> 3de99a4acd318351aea7f5a5edf67b78754c21a7
    <?php require('./includes/nav.php') ?>
    <form method="POST" action="">
        <table>
            <tr>
                <td align="right">
                    <label for="mail">Mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Votre mail" id="mail" name="email" value="
                    <?php if (isset($mail)) {
                        echo $mail;
                    } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mdp">Mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="password" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mdp2">Confirmation du mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="password_verif" />
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="submit" value="Je m'inscris" />
                </td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($erreur_mdp)) {
        echo '<font color="red">' . $erreur_mdp;
    } elseif (isset($erreur)) {
        echo '<font color="red">' . $erreur;
    }
    ?>
</body>
</html>
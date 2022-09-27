<?php
session_start();
require('./includes/db.php');

if($_SESSION && $_SESSION['user']) header('Location: /');

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
            echo 'Wrong email or password';
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
    <title>Inscription</title>
    <meta charset="utf-8">
</head>

<body>
    <?php require('./includes/nav.php') ?>
    <form method="POST" action="">
        <table>
            <tr>
                <td align="right">
                    <label for="mail">Mail :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre mail" id="mail" name="email" value="<?= isset($mail) && $mail ?>" />
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
                <td align="center">
                    <input type="submit" value="Connexion" />
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
<?php
$bdd = new PDO('mysql:host=db:3306;dbname=test;charset=utf8;', 'test', 'test');
if (isset($_POST['forminscription'])) {
    if (!empty($_POST['mdp']) and !empty($_POST['mail']) and !empty($_POST['mdp2'])) {
        if ($_POST['mdp2'] == $_POST['mdp']) {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                if (strpos($_POST['mail'], '@my-digital-school.org')) {
                    $mail = htmlspecialchars($_POST['mail']);
$mdp = sha1($_POST['mdp']);
                    $checkmail = $bdd->prepare('SELECT * FROM users where mail = ?');
                    $checkmail->execute(array($mail));
                    $mailexist = $checkmail -> rowCount();
                    if($mailexist==0){
                        $insertUser = $bdd->prepare('INSERT INTO users(mail,mdp)VALUES(?,?)');
                        $insertUser->execute(array($mail, $mdp));
                        $recup_Id_User = $bdd->prepare('SELECT * FROM users where mail = ? AND mdp=?');
                        $recup_Id_User->execute(array($mail, $mdp));
                        if ($recup_Id_User->rowCount() > 0) {
                            $_SESSION['mail'] = $mail;
                            $_SESSION['mdp'] = $mdp;
                            $_SESSION['id'] = $recup_Id_User->fetch()['id'];
                        }
                    }else{
                        $erreur = "L'adresse email a déjà été utiliser";
                    }
                } else {
                    $erreur = "Il ne s'agit pas d'une adresse mail de MyDigitalSchool";
                }
            } else {
                $erreur = "Votre email n'est pas valide";
            }
        } else {
            $erreur = "Vous devez écrire le même mot de passe";
        }
    } else {
        $erreur = "Vous devez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscription</title>
    <meta charset="utf-8">
</head>

<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td align="right">
                    <label for="mail">Mail :</label>
                </td>
                <td>
                    <input type="email" placeholder="Votre mail" id="mail" name="mail" value="
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
                    <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="mdp2">Confirmation du mot de passe :</label>
                </td>
                <td>
                    <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="center">
                    <br />
                    <input type="submit" name="forminscription" value="Je m'inscris" />
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
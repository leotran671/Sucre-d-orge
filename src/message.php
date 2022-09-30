<?php
session_start();
require('./includes/db.php');
require('./includes/flash.php');
if (!$_SESSION || !$_SESSION['user']) header('Location: /');

$destinataires = $bdd->query('SELECT id,email FROM users ORDER BY email ASC');
$destinataires = $destinataires->fetchAll();

$user = $bdd->prepare('SELECT * FROM users WHERE id = ?');
$user->execute([$_SESSION['user']['id']]);

function getNameFomat($email)
{
    $identity = explode("@", $email)[0];
    [$prenom, $nom] = explode(".", $identity);

    return ucfirst($prenom) . " " . strtoupper($nom);
}

function handlePost()
{
    global $user;
    $_POST = array_map("trim", $_POST);
    $user = $user->fetch();

    try {
        if ($user['credit'] < 1) {
            return flash("Vous ne possedez pas assez de crédit pour envoyer un message.");
        }
        $tuid = (int)htmlspecialchars($_POST['destinataire']);
        if (empty($_POST['destinataire']) || $tuid == 0) {
            return flash("Veuillez choisir un destinataire ");
        }
        if (empty($_POST['message'])){
            return flash("Veuillez saisir un message !");
        }

        global $bdd;
        $message = $bdd->prepare("INSERT INTO messages (uid, tid , msg, status) VALUES (:uid, :tid, :msg, :status)");
        $message->execute([
            'uid' => $_SESSION['user']['id'],
            'tid' => $tuid,
            'msg' => htmlspecialchars($_POST['message']),
            'status' => 'pending'
        ]);

        $updateCredit = $bdd->prepare("UPDATE users SET credit = 0 WHERE id = ?");
        $updateCredit->execute([$_SESSION['user']['id']]);
        $_SESSION['user']['credit'] = $_SESSION['user']['credit'] = 0;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    handlePost();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./includes/head.php') ?>
    <title>Envoyer votre message - My Digital Sucre</title>
    <link rel="stylesheet" href="public/style/message.css">
</head>
<body>
<?php require('./includes/nav.php') ?>

<form method="post">
    <div class="title">
        <h1>Message à envoyer</h1>
    </div>
    <div class="input">
        <label>Destinataire :</label>
        <select name="destinataire" id="destinataire">
            <option selected>Choisissez le nom de votre utilisateur</option>
            <?php foreach ($destinataires as $destinataire) {
                if ($destinataire['id'] != $_SESSION['user']['id']) {
                    ?>
                    <option value="<?= $destinataire['id'] ?>"><?= getNameFomat($destinataire['email']) ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="input">
        <label>Message :</label>
        <div>
                <textarea name="message" id="message" maxlength="255" style="resize: none;"
                          placeholder="Saisissez votre message (max : 255 caractères)"></textarea>
        </div>
    </div>

    <input type="submit" id="envoyer" value="Envoyer Message" name="send" id="send">
</form>

<div class="alerts">
    <?php if (isset($_SESSION['flash'])): ?>
        <?php foreach ($_SESSION['flash'] as $flash): ?>
            <?= "<div class='alert error'>{$flash}</div>" ?>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']) ?>
    <?php endif ?>
</div>
</body>
</html>
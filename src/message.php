<?php
session_start();
require('./includes/db.php');

if(!$_SESSION || !$_SESSION['user']) header('Location: /');

$destinataires = $bdd->query('SELECT id,email FROM users ORDER BY email ASC');
$destinataires = $destinataires->fetchAll();

$user = $bdd->prepare('SELECT * FROM users WHERE id = ?');
$user->execute([$_SESSION['user']['id']]);

function getNameFomat($email) {
    $identity = explode("@", $email)[0];
    [$prenom, $nom] = explode(".", $identity);
    
    return ucfirst($prenom). " ". strtoupper($nom);
}

function handlePost() {
    global $user;
    $_POST = array_map("trim", $_POST);
    $user = $user->fetch();
    
    try{
        if($user['credit'] < 1) throw new Exception("Vous n'avez pas assez de crédit pour envoyer un message");
        if(empty($_POST['destinataire'])) throw new Exception("Veuillez choisir un destinataire");
        if(empty($_POST['message'])) throw new Exception("Veuillez saisir un message");

        global $bdd;
        $tuid = (int) htmlspecialchars($_POST['destinataire']);
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
    } catch (Exception $e){
        echo $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] === "POST") {
    handlePost();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./includes/head.php') ?>
    <title>Message</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <h1>Message à envoyer</h1>
    <form method="post">
        <div>
            <label>Destinataire :</label>
                
            <select name="destinataire" id="destinataire">
                <?php foreach ($destinataires as $destinataire){ 
                    if($destinataire['id']!=$_SESSION['user']['id']){
                    ?>
                        <option value="<?= $destinataire['id'] ?>"><?= getNameFomat($destinataire['email']) ?></option>
                <?php }} ?>
            </select>
        </div>
        <div>
            <label>Message :</label> 
            <div>
                <textarea cols="30" rows="10" name="message" id="message"></textarea>    
            </div>
        </div>
        
        <input type="submit" value="Envoyer Message" name="send" id="send">  
    </form>
</body>
</html>
<?php
session_start();
require('./includes/db.php');

if(!$_SESSION || !$_SESSION['user']) header('Location: /');

$query = $bdd->query('SELECT id,email FROM users ORDER BY email ASC');
$destinataires = $query->fetchAll();

function getNameFomat($email) {
    $identity = explode("@", $email)[0];
    [$prenom, $nom] = explode(".", $identity);
    
    return ucfirst($prenom). " ". strtoupper($nom);
}

function handlePost() {
    try{
        if(isset($_POST['send'])){
            if(!empty($_POST['destinataire'])){
                global $bdd;
                $tuid = (int) htmlspecialchars($_POST['destinataire']);
                $message=htmlspecialchars($_POST['message']);
                $insertMessage = $bdd->prepare("INSERT INTO messages (uid, tid , msg, status) VALUES (?, ?, ?, ?)");
                $insertMessage->execute([
                    $_SESSION['user']['id'], 
                    $tuid, 
                    $message,
                    'pending'
                ]);
            } 
        }
    } catch (Exception $e){
        echo "Vous avez déja envoyé un message";
    }
}

if($_SERVER['REQUEST_METHOD'] === "POST") {
    handlePost();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
</head>
<body>
    <?php require('./includes/nav.php') ?>
    <h1>Message à envoyer</h1>
    <form method="post">
        <div>
            <label>Destinataire :</label>
                
            <select name="destinataire" id="destinataire">
                <?php foreach ($destinataires as $destinataire){ ?>
                        <option value="<?= $destinataire['id'] ?>"><?= getNameFomat($destinataire['email']) ?></option>
                <?php } ?>
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
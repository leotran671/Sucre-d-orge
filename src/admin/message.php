<?php
session_start();
require('../includes/db.php');

function handlePost(){
    global $bdd;

    // check if session email is admin 
    if($_SESSION['user']['email'] == 'admin.admin@my-digital-school.org'){
        $data = json_decode(file_get_contents('php://input'), true);

        // checking if data type is validate or archived
        if($data['type'] == 'validate'){
            $id = $data['id'];
            $query = $bdd->prepare('UPDATE messages SET status = "validate" WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
        } else if($data['type'] == 'archived'){
            $id = $data['id'];
            $query = $bdd->prepare('UPDATE messages SET status = "archived" WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);
        }  
        echo json_encode($query);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePost();
}

?>


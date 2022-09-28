<?php
session_start();
require('../includes/db.php');

function handlePost(){
    global $bdd;

    // check if session email is admin 
    if($_SESSION['user']['email'] == 'admin.admin@my-digital-school.org'){
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $query = $bdd->prepare('DELETE FROM users WHERE id = :id');
        $query->execute([
            'id' => $id
        ]);

        $res = array('success' => "deleted");
        echo json_encode($res);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePost();
}
<?php
session_start();
require('../includes/db.php');

function handlePost(){
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];

    $res = array('local_password' => $_SESSION['user']['password'], 'id' => $data['id']);
    echo json_encode($res);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePost();
}
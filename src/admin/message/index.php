<?php
session_start();
require('../../includes/db.php');

if(!$_SESSION || !$_SESSION['user'])  header('Location: /login.php');
if($_SESSION['user']['email'] !== "admin.admin@my-digital-school.org") header('Location: /');

$users = $bdd->query('SELECT * FROM users ORDER BY created DESC LIMIT 10');
$users = $users->fetchAll();

$pendingMessages = $bdd->query('SELECT * FROM messages WHERE status = "pending" ORDER BY created DESC LIMIT 10');
$pendingMessages = $pendingMessages->fetchAll();

$validateMessages = $bdd->query('SELECT * FROM messages WHERE status = "validate" ORDER BY created DESC LIMIT 10');
$validateMessages = $validateMessages->fetchAll();

$archivedMessages = $bdd->query('SELECT * FROM messages WHERE status = "archived" ORDER BY created DESC LIMIT 10');
$archivedMessages = $archivedMessages->fetchAll();

// display datetime in HH:MM le JJ/MM/AAAA
function formatDate($date) {
    $date = new DateTime($date);
    return $date->format('H\hi  d/m/Y');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - MyDigitalSucre</title>
</head>
<body>
    <main>
        <h1 align=center>Dashboard</h1>
        <hr>
        <a href="/admin">Dashboard</a>        
        <?php if($pendingMessages) : ?>
        <br>
        <h2>Messages en attente</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Message</th>
                    <th>Created</th>
                    <th>Actions</th>
                </Ftr>
            </thead>
            <tbody>
                <?php foreach($pendingMessages as $message): ?>
                    <tr>
                        <td><?= $message['id'] ?></td>
                        <td><?= $message['msg'] ?></td>
                        <td><?= formatDate($message['created']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif; ?>
        <?php if($validateMessages) : ?>
        <br>
        <h2>Messages valider</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Message</th>
                    <th>Created</th>
                </Ftr>
            </thead>
            <tbody>
                <?php foreach($validateMessages as $message): ?>
                    <tr>
                        <td><?= $message['id'] ?></td>
                        <td><?= $message['msg'] ?></td>
                        <td><?= formatDate($message['created']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif; ?>
        <?php if($archivedMessages) : ?>
        <br>
        <h2>Messages archiver</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Message</th>
                    <th>Created</th>
                </Ftr>
            </thead>
            <tbody>
                <?php foreach($archivedMessages as $message): ?>
                    <tr>
                        <td><?= $message['id'] ?></td>
                        <td><?= $message['msg'] ?></td>
                        <td><?= formatDate($message['created']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif ?>
    </main>
</body>
</html>
<style>
    body {
        font-family: sans-serif;
        color: #111;
    }
    main {
        width: 100%;
        max-width: 72rem;
        margin: 0 auto;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tbody tr:hover {
        background-color: #e2e2e2;
    }
    tbody tr {
        border-top: 1px solid #f2f2f2;
        cursor: pointer;
        font-weight: lighter;
    }
    .no-credit {
        color: #c0392b;
    }
    legend {
        font-size: 0.8rem;
        font-weight: lighter;
        margin-bottom: 10px;
    }
    .tool {
        text-align: center;
        width: 0;
    }
</style>
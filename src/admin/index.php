<?php
session_start();
require('../includes/db.php');

if(!$_SESSION || !$_SESSION['user'])  header('Location: /login.php');
if($_SESSION['user']['email'] !== "admin.admin@my-digital-school.org") header('Location: /');

$users = $bdd->query('SELECT * FROM users ORDER BY created DESC LIMIT 10');
$users = $users->fetchAll();

$pendingMessages = $bdd->query('SELECT * FROM messages WHERE status = "pending" ORDER BY created DESC LIMIT 10');
$pendingMessages = $pendingMessages->fetchAll();

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
        <a>Tous messages valider</a>        
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
                        <td>
                            <a href="/admin/message.php?id=<?= $message['id'] ?>">Valider</a>
                            <br>
                            <a href="/admin/message.php?id=<?= $message['id'] ?>">Archiver</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <h2>Utilisateurs</h2>
        <table>
            <thead>
                <th class="id">id</th>
                <th class="email">email</th>
                <th class="created">creation</th>
                <th class="tool"></th>
            </thead>
            <tbody>
                <legend>Les utilisteur en rouge on déjà envoyer leur message</legend>
                <?php foreach($users as $user) { ?>
                    <tr class=<?= $user['credit'] == 0 ? "no-credit" : "" ?>>
                        <td align="center"><?= $user['id'] ?></td>
                        <td align="center"><?= $user['email'] ?></td>
                        <td align="center"><?= formatDate($user['created']) ?></td>
                        <td class="tool"><a href=<?= "/admin/delete.php?" . $user['id'] ?> >Supprimer</a></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
<script>
let tools = document.querySelectorAll('.tool a');

tools.forEach(tool => {
    tool.addEventListener('click', (e) => {
        if(confirm('Are you sure you want to delete this user?')) {
            e.preventDefault();
            let id = tool.getAttribute('href').split('?').pop();
            let tr = tool.parentElement.parentElement;
            let email = tr.children[1].innerText;
            let data = {
                id,
                email
            }
            fetch('/admin/delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json().then((data) => {
                if(data) {
                    tr.remove();
                } else {
                    alert(data.error);
                }
            }))
        }
    })
})

document.querySelectorAll('.tool a').addEventListener('click', function(e) {
    const href = e.target.getAttribute('href');
    e.preventDefault();
    // alert user before delete
    if(confirm('Are you sure you want to delete this user?')) {
        document.location.href = href;
    }
})
</script>
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
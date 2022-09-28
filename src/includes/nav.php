<nav>
    <a <?= $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php" ? "aria-disabled=true" : "href=/" ?> >Accueil</a>
    
    <?php if (isset($_SESSION['user'])) : ?>
        <a <?= $_SERVER['REQUEST_URI'] == "/message.php" ? "aria-disabled=true" : "href=/message.php" ?> >Message</a>
        <a href="/logout.php">Déconnexion</a>
    <?php else : ?>
        <a <?= $_SERVER['REQUEST_URI'] == "/login.php" ? "aria-disabled=true" : "href=/login.php" ?> >Connexion</a>
        <a <?= $_SERVER['REQUEST_URI'] == "/signin.php" ? "aria-disabled=true" : "href=/signin.php" ?> >Inscription</a>
    <?php endif ?>
</nav>
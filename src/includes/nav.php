<nav>
    <a <?= $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php" ? "aria-disabled=true" : "href=/" ?> >Accueil</a>
    <a <?= $_SERVER['REQUEST_URI'] == "/login.php" ? "aria-disabled=true" : "href=/login.php" ?> >Connexion</a>
    <a <?= $_SERVER['REQUEST_URI'] == "/signin.php" ? "aria-disabled=true" : "href=/signin.php" ?> >Inscription</a>
</nav>
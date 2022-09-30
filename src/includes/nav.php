<nav>
   <ul>
      <a <?= $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php" ? "aria-disabled=true" : "href=/" ?>>
         <img src="public/medias/logoMyDigitalSucre.png" width='80' height="40" alt="Logo MyDigtalSucre">
      </a>
      <li>
         <a <?= $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php" ? "aria-disabled=true" : "href=/" ?> >Accueil</a>
      </li>
   
      <?php if (isset($_SESSION['user'])) : ?>
         <li><a <?= $_SERVER['REQUEST_URI'] == "/message.php" ? "aria-disabled=true" : "href=/message.php" ?> >Message</a></li>
         <li><a href="/logout.php">Déconnexion</a></li>
      <?php else : ?>
         <li> <a <?= $_SERVER['REQUEST_URI'] == "/login.php" ? "aria-disabled=true" : "href=/login.php" ?> >Connexion</a></li>
         <li><a <?= $_SERVER['REQUEST_URI'] == "/signin.php" ? "aria-disabled=true" : "href=/signin.php" ?> >Inscription</a></li>
      <?php endif ?>
   </ul>
   <div id="white"><a href="login.php"><img src="public/medias/AmongUs.png" id="AmongUs" width="40" height="40" alt="Among Us"></a>
   
   </div>
   
</nav>
<script src="./public/js/amongUs.js"></script>
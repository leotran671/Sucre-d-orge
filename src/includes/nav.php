<style>
 .navigation{
    background-color:white;
 }
 
 .navigation ul {
    padding:0;
    margin:0;
    list-style-type:none;
    display:flex;
    align-items:center;
 }
 .navigation li {
    margin-left:2px;
    float:left; /*pour IE*/
 }
 .navigation ul li a {
    display:block;
    float:left;   
    width:80px;
    color:black;
    text-decoration:none;
    text-align:center;
    padding:0.7em;
    text-decoration: none;
    background: linear-gradient(to top, black 0%, black 10%, transparent 10.01%) no-repeat left bottom / 0 100%;
    transition: background-size .5s;
    font-size:1.1rem;
 }
 .navigation img {
    margin-left:3rem;
    margin-right:3rem;
    padding-top:0.5rem;
    padding-bottom:0.5rem;
 } 

.navigation ul li a:hover {
  background-size: 100% 100%;
}

@media (max-width: 769px) { 
  .navigation ul {
    justify-content:center;
  }
  .navigation img {
    margin-right:0rem;
    margin-left:1rem;
  }
}
</style>


<div class="navigation">
    <nav>
        <ul>
        <img src="public/medias/logoMyDigitalSucre.png" width='80' height="40" alt="Logo MyDigtalSucre">
       <li><a <?= $_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == "/index.php" ? "aria-disabled=true" : "href=/" ?> >Accueil</a></li>
        
        <?php if (isset($_SESSION['user'])) : ?>
            <li><a href="/logout.php">Déconnexion</a></li>
        <?php else : ?>
           <li> <a <?= $_SERVER['REQUEST_URI'] == "/login.php" ? "aria-disabled=true" : "href=/login.php" ?> >Connexion</a></li>
           <li><a <?= $_SERVER['REQUEST_URI'] == "/signin.php" ? "aria-disabled=true" : "href=/signin.php" ?> >Inscription</a></li>
        <?php endif ?>
        </ul>
    </nav>
</div>

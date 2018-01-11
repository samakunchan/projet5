<?php
#Affichage du bouton de "déconnection" si une session existe
if (isset($_SESSION['username']) && $_SESSION['username'] !==''){
    $log = '<a class="dropdown-item" href="http://localhost/projet5/Public/index.php?page=logout">Déconnection</a>';
    $user = $_SESSION['username'];
}else{$log = ''; $user='admin';}
#Lecture des résultats de la liste de catégorie pour l'avoir dynamiquement dans le layout
$managerCat = new \Models\Manager\CategoryManager();
$data = $managerCat->readAll();
define("LOCAL", "http://localhost/projet5/Public");
define("STYLE", "projet5/Public");
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" href="/<?php echo STYLE?>/src/images/imgjdr/favicon.ico"/>
    <title>Plateforme JDR</title>
    <script src="/<?php echo STYLE?>/src/js/tools.js"></script>
    <link href="/<?php echo STYLE?>/src/css/style.css" rel="stylesheet">
    <link href="/<?php echo STYLE?>/src/css/font.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
          crossorigin="anonymous">
</head>
<body id="main" style="background-color: rgb(77,91,94)">
    <h3 class="text-muted plateform">
        <a style="text-decoration: none; color: grey" href="<?php echo LOCAL;?>/home">Plateforme JDR</a>
    </h3>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark rounded">
        <span class="navbar-brand">
            <a style="text-decoration: none; color: grey" href="<?php echo LOCAL;?>/home">Plateforme JDR
            </a>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav text-md-center nav-justified w-100">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo LOCAL;?>/home">Acceuil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo LOCAL;?>/advert">Annonces</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="<?php echo LOCAL;?>/category"
                       id="dropdown01"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">Catégorie</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="<?php echo LOCAL;?>/category">Toutes les catégories</a>
                        <?php foreach ($data as $item){
                            $name = strtolower($item->getUrlCat());
                            echo '<a class="dropdown-item" href="'.LOCAL.'/category/'.$item->getId().'/'.$name.'">'.ucfirst($item->getUrlCat()).'</a>';
                        }?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="<?php echo LOCAL;?>/category"
                       id="dropdown01"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">Partie</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="<?php echo LOCAL;?>/party/page-1">Rechercher une partie</a>
                        <a class="dropdown-item" href="<?php echo LOCAL;?>/propositionParty">Proposer une partie</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="dropdown01"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Administration</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="<?php echo LOCAL;?>/memberArea/<?php echo $user;?>">Espace membre</a>
                        <a class="dropdown-item" href="<?php echo LOCAL;?>/about">A propos</a>
                        <?php echo $log;?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main role="main" class="containers">
        <!-- Toute les vus sont générés dans la variable $contenu -->
        <?php echo $contenu?>
        <button id="rolTop">
            Haut de la page
        </button>
    </main>
    <footer>
        &copy; Samakunchan
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src='/<?php echo STYLE?>/src/js/tinymce/tinymce.min.js'></script>
    <script type="text/javascript" src="/<?php echo STYLE?>/src/js/global.js"></script>
    <script type="text/javascript" src="/<?php echo STYLE?>/src/js/scroll.js"></script>
</body>
</html>



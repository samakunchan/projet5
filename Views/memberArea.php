<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;
#Changement de nom des différents rôles
switch ($donnees[0]->getRoles()) {
    case 'ROLE_ADMIN':
        $roles =  'ADMINISTRATEUR';
        $gestion = '';
        break;
    case 'ROLE_MODO':
        $roles =  'MODERATEUR';
        $gestion = '';
        break;
    case 'ROLE_USER';
        $roles =  'UTILISATEUR';
        $gestion = '';
        break;
    default:
        $roles =  'VOUS N\'AVEZ PAS DE ROLE VALIDE';
}
?>
<h1>Vous êtes sur votre espace membre</h1>
<section class="row memberPage">
    <nav class="col-lg-12 profil row">
        <h2 class="col-lg-12">Personnage <?php echo $donnees[0]->getFullname();?></h2>
        <p style="color: #0d88c1" class="col-lg-12">Classe : <?php echo $roles ?> </p>
        <?php if ($donnees[1]): ?>
            <p style="color: red;"><?php echo $donnees[1] ?></p>
        <?php endif; ?>
        <div class="imageContainer col-lg-6">
            <img class="img-responsive" src="/projet5/Public/src/images/avatar/<?php echo $donnees[0]->getAvatar()?>"
                 alt="profil de <?php echo $donnees[0]->getFullname();?>"
                 style="width: 250px;">
            <img class="dragon" src="/projet5/Public/src/images/imgjdr/dragon.png" alt="logo d'un dragon">
        </div>
        <div class="sorts col-lg-5">
            <table>
                <tr>
                    <td>
                        <h2>Infos perso</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="col-lg-12">Login______________ </p>
                    </td>
                    <td>
                        <p class="col-lg-12"><?php echo $donnees[0]->getUsername();?> </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="col-lg-12">Email______________</p>
                    </td>
                    <td>
                        <p class="col-lg-12"><?php echo $donnees[0]->getEmail();?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="col-lg-12">Date d'inscription______________</p>
                    </td>
                    <td>
                        <p class="col-lg-12"><?php echo $donnees[0]->getDates() ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="col-lg-12">Parties créés______________</p>
                    </td>
                    <td>
                        <p class="col-lg-12"><?php echo count($donnees[5])?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="col-lg-12">Parties en cours______________</p>
                    </td>
                    <td>
                        <p class="col-lg-12"><?php echo count($donnees[2])?></p>
                    </td>
                </tr>
            </table>

        </div>
    </nav>

    <nav class="col-lg-12 navSort">
        <h2>Listes des sorts</h2>
        <div class=" row">
            <form class="col-lg-5 sorts" method="post" enctype="multipart/form-data">
                <h4>Kage bushin</h4>
                <p>
                    <em>Cliquez sur "Choisissez un fichier". Permet de changer l'avatar du profil</em>
                </p>
                <input id="avatar" type="file" name="avatar">
                <input id="id" type="hidden" name="id" value="<?php echo $donnees[0]->getId();?>">
                <input style="width: 20%;" type="submit" class="btn btn-primary" value="Envoyer">
            </form>
            <div class="col-lg-6 sorts">
                <h4>Data Power Punch</h4>
                <p>
                    <em>Cliquez sur "Modifier vos infos". Permet de modifier les informations personnels de type login, mdp ect...</em>
                </p>
                <div class="btn btn-primary ">
                    <a style="text-decoration: none; color: white;"
                       href="http://localhost/projet5/Public/memberArea/<?php echo $donnees[0]->getUsername()?>-parameter">
                        Modifier vos infos
                    </a>
                </div>
            </div>
            <div class="col-lg-11 sorts">
                <h4>Super Party Launch</h4>
                <p>
                    <em>Cliquez sur "Proposer une partie". Permet de créer et de proposer une partie au rôliste. Nécessite un univers réfléchi.</em>
                </p>
                <div class="btn btn-primary">
                    <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/propositionParty">Proposer une partie</a>
                </div>
            </div>

        </div>
    </nav>
    <nav class="status">
        <h2>Votre Status</h2>
        <?php if ($donnees[2]): ?>
            <div>
                <h4>Partie en cours :</h4>
                <ul>
                    <?php foreach ($donnees[2] as $party):
                        $titleForUrl = str_replace(' ', '-', $party->getBookingTitle());
                        ?>
                        <li>
                            <a style="text-decoration: none" href="http://localhost/projet5/Public/show/<?php echo strtolower($titleForUrl)?>-<?php echo $party->getBooked()?>">
                                <?php echo $party->getBookingTitle()?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($donnees[5]): ?>
            <div>
                <h4>Vous êtes le maître du jeu de :</h4>
                <ul>
                    <?php foreach ($donnees[5] as $mj):
                        $titleForUrl = str_replace(' ', '-', $mj->getTitle());
                        ?>
                        <li>
                            <a style="text-decoration: none" href="http://localhost/projet5/Public/show/<?php echo strtolower($titleForUrl)?>-<?php echo $mj->getId()?>">
                                <?php echo $mj->getTitle()?>
                            </a>__________
                            <div class="btn btn-info">
                                <a style="color: white; text-decoration: none"
                                   href="http://localhost/projet5/Public/propositionParty/edit/<?php echo strtolower($titleForUrl)?>-<?php echo $mj->getId()?>">
                                    Modifier
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (!$donnees[2] && !$donnees[5]) : ?>
            <p>Vous êtes actuellement inactifs</p>
        <?php endif; ?>
    </nav>
    <nav class="adminModo">
        <?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO'): ?>
            <h2>Compétences cachés</h2>
            <em>Partie réservé aux administrateur et au modérateur</em>
            <div class="col-lg-12">
                <?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN'): ?>
                    <div class="btn btn-secondary">
                        <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/admin">Gestion des utilisateurs</a>
                    </div>
                <?php endif; ?>
                <?php if ($donnees[4] || $donnees[3] || $donnees[6]): ?>
                    <div class="btn btn-danger">
                        <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/signals">Signalement détecter</a>
                    </div>
                <?php else: ?>
                    <div class="btn btn-info disabled">
                        Pas de signalement
                    </div>
                <?php endif; ?>
                <div class="btn btn-info">
                    <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/advert-write">Ecrire une annonce</a>
                </div>
                <div class="btn btn-info">
                    <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/advert-list">Gestion des annonces</a>
                </div>
                <div class="btn btn-info">
                    <a style="text-decoration: none; color: white;" href="http://localhost/projet5/Public/category-write">Créer une nouvelle catégorie</a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</section>


<?php
$nBJoueurActuel = count($donnees[1]);
if (isset($_GET['title']) && !empty($_GET['title']) &&
    isset($_GET['id']) && !empty($_GET['id'])){
    if ($donnees[0]){
        if ($_GET['title'] !== $donnees[0]->getUrl()){
            header('Location: '.$donnees[0]->getUrl().'-'.$donnees[0]->getId().'');
            exit();
        }
    }else{
        die('La page que vous demandez n\'existe pas');
    }
}
if (isset($_SESSION['username'])){
    $data = $donnees[5];
}else{
    $data = $donnees[2];
}
?>
<section class="pageShows">
    <div class="sectionShow">
        <?php if ($data):?>
            <div class="alert alert-success">
                <p><?php echo $data;?></p>
            </div>
        <?php endif; ?>
        <h3><?php echo $donnees[0]->getTitle(); ?></h3>
        <div class="row ">
            <div class="pageShowIn ">
                <img class="imgShow" src="/projet5/Public/src/images/logos/<?php echo $donnees[0]->getImages()?>"
                     alt="images-<?php echo $donnees[0]->getTitle()?>">
            </div>
            <div class="book row col-lg-12">
                <h4 class="col-lg-6">Nombre de joueurs requis : <?php echo $donnees[0]->getSpotMax()?></h4>
                <h4 class="col-lg-6">Nombre de joueur actuel : <?php echo $nBJoueurActuel?></h4>
                <?php if ($donnees[0]->getSpotMax() !== count($donnees[1])): ?>
                    <?php if (isset($donnees[2])): ?><!-- Si la session existe on affiche sinon on se connecte -->
                        <?php if ($donnees[3]): ?>
                            <form method="post">
                                <input type="hidden" name="mode" value="leave">
                                <input type="hidden" name="action" value="booking">
                                <input type="hidden" name="url" value="<?php echo $donnees[0]->getUrl();?>">
                                <input type="hidden" name="booking" value="<?php echo $donnees[0]->getId();?>">
                                <input type="hidden" name="booking_title" value="<?php echo $donnees[0]->getTitle();?>">
                                <input type="hidden" name="id_author" value="<?php echo $donnees[2]->getId();?>">
                                <input type="submit" class="btn btn-danger" value="Quitter">
                            </form>
                        <?php else: ?>
                            <form method="post">
                                <input type="hidden" name="mode" value="join">
                                <input type="hidden" name="action" value="booking">
                                <input type="hidden" name="url" value="<?php echo $donnees[0]->getUrl();?>">
                                <input type="hidden" name="booking" value="<?php echo $donnees[0]->getId();?>">
                                <input type="hidden" name="booking_title" value="<?php echo $donnees[0]->getTitle();?>">
                                <input type="hidden" name="id_author" value="<?php echo $donnees[2]->getId();?>">
                                <input type="submit" class="btn btn-success" value="Rejoindre">
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-success col-lg-12">
                            <p>Vous devez être connecté pour rejoindre cette partie.</p>
                            <div class="btn btn-primary">
                                <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/register">Connecter vous.</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (isset($donnees[2])): ?><!-- Si la session existe on affiche sinon on se connecte -->
                        <?php if ($donnees[3]): ?>
                            <form method="post">
                                <input type="hidden" name="mode" value="leave">
                                <input type="hidden" name="url" value="<?php echo $donnees[0]->getUrl();?>">
                                <input type="hidden" name="booking" value="<?php echo $donnees[0]->getId();?>">
                                <input type="hidden" name="booking_title" value="<?php echo $donnees[0]->getTitle();?>">
                                <input type="hidden" name="id_author" value="<?php echo $donnees[2]->getId();?>">
                                <input type="button" class="btn btn-danger col-lg-3">
                                    Quitter
                                </input>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="alert alert-info col-lg-12">
                        <p>Toutes les places sont prises.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($donnees[1]): ?>
            <div class="row pageShowIn">
                <table class="col-lg-6">
                    <tr>
                        <td >
                            <h3>Participants</h3>
                        </td>
                    </tr>
                    <tr class="row tr">
                        <?php foreach ($donnees[1] as $roliste): ?>
                            <td class="col-lg-12"> <?php echo $roliste->getFullname()?></td>
                        <?php endforeach; ?>
                    </tr>
                </table>

                <div class="col-lg-6 tr">
                    <h4 class="col-lg-6">Maître du jeu:</h4>
                    <p><?php echo $donnees[0]->getNameAuthor();?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="col-lg-6">
                <h4 class="col-lg-6">Maître du jeu:</h4>
                <p><?php echo $donnees[0]->getNameAuthor();?></p>
            </div>
        <?php endif; ?>
        <hr>
        <div class="row pageShowIn">
            <h4 class="col-lg-12">Synopsis</h4>
            <p><?php echo $donnees[0]->getContent();?></p>
        </div>
    </div>
</section>
<?php if (isset($_SESSION) && !empty($_SESSION)): ?>
    <section class="pageShowComment ">
        <?php if ($donnees[4]): ?>
            <?php foreach ($donnees[4] as $partyCom):?>
                <div class="viewCommentParty">
                    <p>Auteur : <?php echo $partyCom->getAuthor();?></p>
                    <p><?php echo $partyCom->getContent();?> </p>
                    <em><?php echo $partyCom->getDates()?></em>
                    <hr>
                    <?php if ($partyCom->getSignals()=== 1): ?>
                        <p class="signalement">Ce commentaire a été signalé</p>
                    <?php else: ?>
                    <div class="col-lg-2">
                        <form method="post">
                            <input type="hidden" name="action" value="signal">
                            <input type="hidden" name="diag_id" value="<?php echo $partyCom->getId()?>">
                            <input type="submit" class="btn btn-default" value="Signaler">
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div>
            <form method="post">
                <input type="hidden" name="author" value="<?php echo $_SESSION['username']?>">
                <input type="hidden" name="party_id" value="<?php echo $donnees[0]->getId();?>">
                <input type="hidden" name="token_csrf" value="<?php echo \Controllers\FireWallController::tokenCSRF('ProtectedCommentParty');?>">
                <input type="hidden" name="action" value="partyComment">
                <label for="contenu">Ecrire un commentaire</label>
                <textarea name="content" id="contenu" cols="30" rows="10"></textarea>
                <input type="submit" value="Publier">
            </form>
        </div>
    </section>
<?php endif; ?>

<?php use Controllers\FireWallController;?>
<section class="advertPage">
    <!-- Affiche les alertes error -->
    <?php if ($donnees[3]):?>
    <div class="alert alert-danger">
        <p><?php echo $donnees[3];?></p>
    </div>
    <?php endif; ?>
    <!-- Affiche les alertes de succès -->
    <?php if ($donnees[4]):?>
    <div class="alert alert-success">
        <p><?php echo $donnees[4];?></p>
    </div>
    <?php endif; ?>

    <!-- La vue des annonces -->
    <section class="annonce">
        <h1><?php echo $donnees[0][0]->getTitle();?> <br> <em>Créé le : <?php echo $donnees[0][0]->getDates();?></em></h1>
        <hr>
        <p><?php echo $donnees[0][0]->getContent();?></p>
    </section>

    <!-- La vue des commentaires -->
    <section class="viewComment">
        <h1>Commentaires</h1>
        <!-- Si il existe des commentaires, on affiche les commentaires -->
        <?php if ($donnees[2]): ?>
            <?php foreach ($donnees[2] as $com):?>
                <article>
                    <p class="auteur">Auteur : <?php echo $com->getAuthor()?></p>
                    <p> <?php echo $com->getContent()?></p><em><?php echo $com->getDates();?></em>
                    <?php if ($donnees[1]):?>
                    <?php if ($donnees[1]->getFullname()===$com->getAuthor()):?>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="btn btn-secondary">
                                <a style="text-decoration: none; color: white" href="http://localhost/projet5/Public/comment/edit-<?php echo $com->getId()?>">Modifier</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <!-- Si un signalement est détecté pour ce commentaire, on affiche le paragraphe ci-desous -->
                        <?php if ($com->getSignals()=== 1): ?>
                            <p class="signalement">Ce commentaire a été signalé</p>
                            <!-- Dans le cas contraire, on affiche le bouton -->
                        <?php else: ?>
                            <div class="col-lg-2">
                                <form method="post">
                                    <input type="hidden" name="mode" value="signaler">
                                    <input type="hidden" name="com_id" value="<?php echo $com->getId();?>">
                                    <input style="margin: 0; padding: 6px; width: 100%" type="submit"
                                           class="btn btn-secondary" value="Signaler">
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr>
                </article>
            <?php endforeach; ?>
            <!-- Si il n'y a pas de commentaire, on affiche le paragraphe ci-dessous -->
        <?php else: ?>
            <p>Pas de commentaire pour cette annonce pour le moment.</p>
        <?php endif; ?>
    </section>
    <!-- On control si l'utilisateur existe. La session est utilisé pour avoir le reste des données sous forme de tableau -->
    <?php if ($donnees[1]):?>
    <section class="comments">
        <!-- Si l'utilisateur possède l'un de ces 3 rôles ... -->
        <?php if ($donnees[1]->getRoles()=== 'ROLE_ADMIN' ||
            $donnees[1]->getRoles()=== 'ROLE_MODO' ||
            $donnees[1]->getRoles()=== 'ROLE_USER'):?>
            <!-- ..., il aura accès à l'espace commentaire -->
        <form method="post">
            <input type="hidden" name="mode" value="commenter">
            <input type="hidden" name="author" value="<?php echo $donnees[1]->getFullname();?>">
            <input type="hidden" name="art_id" value="<?php echo $donnees[0][0]->getId();?>">
            <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedFormComment') ?>">
            <label for="commentaires">Ecrire un commentaire</label>
            <textarea name="content" id="commentaires" cols="30" rows="10"></textarea>
            <input type="submit" value="Ajouter un commentaire">
        </form>
        <?php endif;?>
    </section>
    <?php endif;?>
</section>

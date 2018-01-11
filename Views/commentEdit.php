<?php use Controllers\FireWallController;?>
    <!-- Si l'utilisateur possède l'un de ces 3 rôles, on affiche la page -->
<?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' ||
$donnees[0]->getRoles()=== 'ROLE_MODO' ||
$donnees[0]->getRoles()=== 'ROLE_USER'):?>
<h1>Page d'edition de commentaire</h1>
<div class="row">
    <div class="col-lg-3">
        <div class="btn btn-info">
            <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/advert">Retour vers la page d'annonce</a>
        </div>
    </div>
    <div class="col-lg-6">
        <form method="post">
            <input type="hidden" name="mode" value="supprimer">
            <input type="hidden" name="id" value="<?php echo $donnees[1]->getId();?>">
            <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedFormCommentSupp') ?>">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
</div>
<form method="post">
    <input type="hidden" name="author" value="<?php echo $donnees[0]->getUsername();?>">
    <input type="hidden" name="id" value="<?php echo $donnees[1]->getId();?>">
    <input type="hidden" name="mode" value="modifier">
    <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedFormComment') ?>">
    <label for="contenu">Contenu</label>
    <textarea name="content" id="contenu" cols="30" rows="10"><?php echo $donnees[1]->getContent();?></textarea>
    <input type="submit" value="Modifier le commentaire">
</form>
<?php endif; ?>
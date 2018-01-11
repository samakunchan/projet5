<h1>Listes des annonces</h1>
<!-- Affiche le boutonde retour à l'espace membre -->
<div class="btn btn-info">
    <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
</div>
<hr>
<?php use Controllers\FireWallController;?>
<!-- Si l'utilisateur possède l'un de ces 2 rôles, on affiche la page -->
<?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO'): ?>
    <!-- Si une action de suppression est en cours, affiche la partie ci dessous pour confirmer ou non la suppression -->
    <?php if ($donnees[2]):?>
    <div class="alert alert-danger">
        <form method="post">
            <p>Confirmer la suppression de l'annonce : <?php echo $donnees[2]['title'];?> </p>
            <input type="hidden" name="id" value="<?php echo $donnees[2]['id'];?>">
            <input type="hidden" name="mode" value="supprimer">
            <input type="hidden" name="title" value="<?php echo $donnees[2]['title'];?> ">
            <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedAdvertSuppression')?>">
            <input type="submit" value="Supprimer" class="btn btn-danger">
        </form>
    </div>
    <?php endif;?>
<section>
    <!-- Si les données existe, on affiche les données -->
    <?php foreach ($donnees[1] as $donnee): ?>
    <div class="row">
        <div class="col-lg-4" >
            <h3>
                <a href="http://localhost/projet5/Public/advert-<?php echo $donnee->getUrl()?>"><?php echo $donnee->getTitle();?></a>
            </h3>
        </div>
        <div class="col-lg-4" >
            <em><?php echo $donnee->getDates();?></em>
        </div>

        <div class="col-lg-4">
            <div class="btn btn-primary">
                <a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/<?php echo $donnee->getUrl()?>-<?php echo $donnee->getId()?>">Modifier</a>
            </div>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $donnee->getId();?>">
                <input type="hidden" name="title" value="<?php echo $donnee->getTitle();?>">
                <input type="hidden" name="mode" value="confirmer">
                <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedAdvertSuppression')?>">
                <input style="margin: 0; padding: 6px; width: 100%" type="submit" value="Supprimer" class="btn btn-danger col-lg-4">
            </form>
        </div>
    </div>
        <hr>
</section>
<?php endforeach; ?>
<?php endif; ?>

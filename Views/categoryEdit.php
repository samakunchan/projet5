<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;?>
<!-- Affiche les alertes error -->
<?php if ($donnees[2]):?>
    <div class="alert alert-danger">
        <p><?php echo $donnees[2];?></p>
    </div>
<?php endif; ?>
<!-- Affiche les alertes succès -->
<?php if ($donnees[3]):?>
    <div class="alert alert-success">
        <p><?php echo $donnees[3];?></p>
    </div>
<?php endif; ?>
<!-- Si l'utilisateur possède l'un de ces 2 rôles, on affiche la page -->
<?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO'): ?>
    <div class="btn btn-info">
        <a style="color: white" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
    </div>
    <section class="row annonce">
        <h1>Modifier une catégorie</h1>
        <form style="width: 100%" method="post">
            <p>
                <label for="cat_name">Nom</label>
            </p>
            <input type="text" name="cat_name" id="title" value="<?php echo $donnees[1]->getCatName();?>" required>
            <p>
                <label for="description">Description</label>
            </p>
            <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedCategoryEdit') ?>">
            <textarea name="description" id="contenu">
                <?php echo $donnees[1]->getDescription();?>
            </textarea>
            <input type="submit" value="Modifier">
        </form>
    </section>
<?php endif; ?>
<script src="/projet5/Public/src/js/global.js"></script>
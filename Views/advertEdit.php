<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;
?>
<section class="advertEdit">
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
    <h1>Page de modification d'annonce</h1>
    <!-- Control si l'utilisateur possède bien l'un de ces 2 rôles, si c'est le cas, on affiche la page -->
    <?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO'): ?>
        <div class="btn btn-info">
            <a style="color: white" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
        </div>
        <div class="btn btn-info">
            <a style="color: white" href="/advert-list">Retour à la gestion d'annonce</a>
        </div>
        <section class="row annonces">
            <h1>Modifier une annonce</h1>
            <form style="width: 100%" method="post">
                <p>
                    <label for="title">Titre</label>
                </p>
                <input type="text" name="title" id="title" value="<?php echo $donnees[1]->getTitle();?>" required>
                <p>
                    <label for="contenu">Contenu</label>
                </p>
                <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedFormAdvertEdit') ?>">
                <textarea name="content" id="contenu"><?php echo $donnees[1]->getContent();?></textarea>
                <input type="submit" value="Modifier">
            </form>
        </section>
    <?php endif; ?>
</section>
<script src="/projet5/Public/src/js/global.js"></script>
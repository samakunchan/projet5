<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;
?>
<!-- Affiche les alertes error -->
<?php if ($donnees[1]):?>
    <div class="alert alert-danger">
        <p><?php echo $donnees[1];?></p>
    </div>
<?php endif; ?>
<!-- Affiche les alertes succès -->
<?php if ($donnees[2]):?>
    <div class="alert alert-success">
        <p><?php echo $donnees[2];?></p>
    </div>
<?php endif; ?>
<!-- Si l'utilisateur possède l'un de ces 2 rôles, on affiche la page -->
<?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO'): ?>
    <div class="btn btn-info">
        <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
    </div>
    <section class="row annonceW">
        <h1>Ecrire une annonce</h1>
        <form style="width: 100%" method="post">
            <?php
            ToolsForm::input(['type'=> 'text','name'=> 'title','lenght' => '150'], 'Titre');
            ToolsForm::textArea('content', 'content');
            ToolsForm::submit('Publier', 'advert');
            ToolsForm::token('token_csrf', FireWallController::tokenCSRF('protectedFormAdvert'));
            ?>
        </form>
    </section>
<?php endif; ?>
<script src="/projet5/Public/src/js/global.js"></script>

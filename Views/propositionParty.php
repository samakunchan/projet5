<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;
//var_dump($donnees);
//var_dump($_POST);
//var_dump($_FILES);
?>
<?php if ($donnees[2]):?>
    <div class="alert alert-danger">
        <p><?php echo $donnees[2];?></p>
    </div>
<?php endif; ?>
<?php if ($donnees[3]):?>
    <div class="alert alert-success">
        <p><?php echo $donnees[3];?></p>
    </div>
<?php endif; ?>
<?php if ($donnees[0]->getRoles()=== 'ROLE_ADMIN' || $donnees[0]->getRoles()=== 'ROLE_MODO' || $donnees[0]->getRoles()=== 'ROLE_USER'):;?>
    <div class="btn btn-info">
        <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username'];?>">Retour à l'espace membre</a>
    </div>
    <section class="row annonce">
        <h1 class="col-lg-12">Décrivez votre synopsis</h1>
        <form style="width: 100%" method="post" enctype="multipart/form-data">
            <p>
                <label for="title">Titre</label>
            </p>
            <input id="title" type="text" name="title" maxlength="150" required>

            <label for="categories">Catégories</label>
            <select name="categories" id="categories">
                <?php foreach ($donnees[1] as $cat):?>
                <option value="<?php echo $cat->getId();?>"><?php echo $cat->getCatName();?></option>
                <?php endforeach;?>
            </select>

            <label for="nbPlayer">Nombres de joueurs max</label>
            <select name="nbPlayer" id="nbPlayer">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5 ou plus</option>
            </select>

            <p>
                <label for="contenu">Contenu</label>
            </p>
            <textarea style="width: 80%" cols="30" rows="50" id="contenu" name="content"></textarea>
            <h3>
                <label for="images">Mettre une image en avant</label>
            </h3>
            <input id="images" type="file" name="images">
            <!-- Envoie l'id du créateur de la partie pour l'ajout du logo -->
            <input id="id" type="hidden" name="id_file" value="<?php echo $donnees[0]->getId();?>">

            <input type="hidden" name="mode" value="proposition">
            <input type="hidden" name="id_author" value="<?php echo $donnees[0]->getId();?>">
            <input type="hidden" name="name_author" value="<?php echo $donnees[0]->getFullname();?>">
            <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedFormProposition');?>">
            <input  type="submit" value="Publier">
        </form>
    </section>
<?php endif;?>
<script src="/projet5/Public/src/js/global.js"></script>
<?php use Controllers\FireWallController;?>
<section class="pageSignal">
    <h1>Page des signalements</h1>
    <div class="btn btn-info">
        <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
    </div>
    <h2>Signalement au niveau des commentaires.</h2>
    <?php if ($donnees[3]):?>
        <div class="alert alert-danger">
            <p><?php echo $donnees[3];?></p>
        </div>
    <?php endif; ?>
    <?php if ($donnees[4]):?>
        <div class="alert alert-success">
            <p><?php echo $donnees[4];?></p>
        </div>
    <?php endif; ?>
    <?php
    if ($donnees[1]):
        foreach ($donnees[1] as $signal): ?>
            <h4>Commentaire de : <?php echo $signal->getAuthor();?></h4>
            <p><?php echo $signal->getContent() ?></p>
            <div class="row">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="conserverCom">
                    <input type="submit" value="Conserver" class="btn btn-secondary">
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="supprimerCom">
                    <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('SuppressComment')?>">
                    <input type="submit" value="Supprimer" class="btn btn-danger">
                </form>
            </div>
            <hr>
        <?php endforeach; else: ?>
        <p>Pas de signalement au niveau des commentaires.</p>
    <?php endif; ?>

    <!--  -->
    <h2>Signalement au niveau des parties.</h2>
    <?php
    if ($donnees[2]):
        foreach ($donnees[2] as $signal): ?>
            <h4>Créé par : <?php echo $signal->getNameAuthor();?></h4>
            <p><?php echo $signal->getContent() ?></p>
            <div class="row">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="conserverPart">
                    <input type="submit" value="Conserver" class="btn btn-secondary">
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="supprimerPart">
                    <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('SuppressParty')?>">
                    <input type="submit" value="Supprimer" class="btn btn-danger">
                </form>
            </div>
            <hr>
        <?php endforeach; else: ?>
        <p>Pas de signalement au niveau des parties.</p>
    <?php endif; ?>

    <h2>Signalement au niveau des commentaires - parties.</h2>
    <?php
    if ($donnees[5]):
        foreach ($donnees[5] as $signal): var_dump($signal->getId())?>
            <h4>Créé par : <?php echo $signal->getAuthor();?></h4>
            <p><?php echo $signal->getContent() ?></p>
            <div class="row">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="conserverPartCOM">
                    <input type="submit" value="Conserver" class="btn btn-secondary">
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $signal->getId()?>">
                    <input type="hidden" name="mode" value="supprimerPartCOM">
                    <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('SuppressCOMParty')?>">
                    <input type="submit" value="Supprimer" class="btn btn-danger">
                </form>
            </div>
            <hr>
        <?php endforeach; else: ?>
        <p>Pas de signalement au niveau des parties.</p>
    <?php endif; ?>
</section>
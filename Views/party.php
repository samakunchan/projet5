<section class="partyPage">
    <?php if ($donnees[1]): ?>
        <div class="alert alert-success">
            <p><?php echo $donnees[1];?></p>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="row pagination col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo \Controllers\PartyController::precedente(); echo \Controllers\PartyController::pageActuel() ;echo \Controllers\PartyController::suivante();?></p>
        </div>
        <?php foreach ($donnees[0] as $party): ?>
        <div class="partySection">
            <h2 class="col-lg-12 <?php echo strtolower($party->getCatName())?>">
                <a style="text-decoration: none" href="http://localhost/projet5/Public/show/<?php echo $party->getUrl()?>-<?php echo $party->getId()?>">
                    <?php echo $party->getTitle()?>
                </a>
            </h2>
            <h3 class="col-lg-12">Catégorie :
                <a style="text-decoration: none" href="http://localhost/projet5/Public/category/<?php echo strtolower($party->getCatName())?>">
                    <?php echo $party->getCatName()?>
                </a>
            </h3>
            <div class="partyContent">
                <img class="imgParty" src="/projet5/Public/src/images/logos/<?php echo $party->getImages()?>"
                     alt="images-<?php echo $party->getTitle()?>">
                <p><?php echo substr($party->getContent(), 0, 500)?> ...</p>
            </div>
            <div class="signalement col-lg-12">
                <?php if ($party->getSignals() === 1): ?>
                    <p class="sigText">Cette partie ci-dessus a été signalé comme non conforme.</p>
                    <hr>
                <?php else: ?>
                <div class="col-lg-2">
                    <form method="post" class="col-lg-12">
                        <input type="hidden" name="mode" value="signaler">
                        <input type="hidden" name="part_id" value="<?php echo $party->getId();?>">
                        <input type="submit" value="Signaler" class="btn btn-secondary ">
                    </form>
                </div>
                    <hr>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="row pagination col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo \Controllers\PartyController::precedente(); echo \Controllers\PartyController::pageActuel() ;echo \Controllers\PartyController::suivante();?></p>
    </div>
</section>

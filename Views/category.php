<section class="categoryPage">
    <h1>Toutes les catégories</h1>
    <!-- Si un utilisateur est connecté, on affiche toute les catégories et la possibilité de les modifier -->
        <?php if (isset($_SESSION['username'])): ?>
            <?php foreach ($donnees[0] as $donnee):?>
    <div class="<?php echo strtolower($donnee->getCatName());?> jdr">
        <h2>
            <a href="http://localhost/projet5/Public/category/<?php echo $donnee->getId();?>/<?php echo strtolower($donnee->getCatName());?>">
                <?php echo $donnee->getCatName();?>
            </a>
        </h2>
        <!-- Si l'utilisateur possède l'un de ces 2 rôles, on affiche le bouton "modifier" -->
            <?php if ($donnees[1]->getRoles()=== 'ROLE_ADMIN' || $donnees[1]->getRoles()=== 'ROLE_MODO'): ?>
            <a href="http://localhost/projet5/Public/category-edit/<?php echo $donnee->getId() ?>">Modifier</a>
        <?php endif; ?>
        <p><?php echo $donnee->getDescription();?></p>
    </div>
            <?php endforeach; ?>
            <!-- Si il n'y a aucun utilisateur de connecté, on affiche simplement toute les catégories -->
        <?php else: ?>
            <?php foreach ($donnees as $donnee): ?>
        <div class="<?php echo strtolower($donnee->getCatName());?> jdr">
            <h2>
                <a href="http://localhost/projet5/Public/category/<?php echo $donnee->getId();?>/<?php echo strtolower($donnee->getUrlCat());?>">
                    <?php echo $donnee->getCatName();?>
                </a>
            </h2>
            <p><?php echo $donnee->getDescription();?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

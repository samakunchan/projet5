<?php if (isset($donnees[1]) && ! empty($donnees[1])):?>
    <?php
    if (isset($_GET['title']) && !empty($_GET['title']) &&
        isset($_GET['id']) && !empty($_GET['id'])){
        if ($donnees[1]){
            if ($_GET['title'] !== $donnees[1]->getUrlCat()){
                $delai=0;
                $url='http://localhost/projet5/Public/category/'.$donnees[1]->getId().'/'.$donnees[1]->getUrlCat();
                header("Refresh: $delai;url=$url");
                exit();
            }
        }else{
            die('La page que vous demandez n\'existe pas');
        }
    }
?>
<section class="singleCategory ">
    <h1><?php echo ucfirst($donnees[1]->getCatName())?></h1>
    <?php foreach ($donnees[0] as $donnee): ?>
        <div class="<?php echo $_GET['title'];?> jdr">
            <h3>
                <a href="http://localhost/projet5/Public/show/<?php echo $donnee->getUrl()?>-<?php echo $donnee->getId()?>">
                    <?php echo $donnee->getTitle();?>
                </a>
            </h3>
            <p><?php echo $donnee->getContent();?></p>
        </div>
    <?php endforeach; ?>
</section>
    <?php else: ?>
<section class="singleCategoryEmpty">
    <h1>Catégorie vide</h1>
    <article>
        <p>Il n'y a pas de sujet concerant cette catégorie.</p>
        <div class="btn btn-primary">
            <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/propositionParty">Soyez les premiers</a>
        </div>
    </article>
</section>
<?php endif; ?>

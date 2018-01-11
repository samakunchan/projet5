<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController; //var_dump($_POST);
?>
<h1>Modifier votre profil</h1>
<?php if ($donnees[1]): ?>
    <div class="alert alert-danger">
        <p><?php echo $donnees[1]; ?></p>
    </div>
<?php endif; ?>
<?php if ($donnees[2]):?>
    <div class="alert alert-success">
        <p><?php echo $donnees[2];?></p>
    </div>
<?php endif; ?>
<div class="btn btn-info">
    <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
</div>
<section class="row paramater">
    <form style="width: 100%" method="post">
        <?php
        ToolsForm::input(['type'=> 'text','name'=> 'fullname','lenght' => '20'], 'Nom complet', $donnees[0]->getFullname());
        ToolsForm::input(['type'=> 'text','name'=> 'username','lenght' => '20'], 'pseudo', $donnees[0]->getUsername());
        ToolsForm::input(['type'=> 'email','name'=> 'email','lenght' => '80'], 'Email', $donnees[0]->getEmail());
        ToolsForm::input(['type'=> 'password','name'=> 'password','lenght' => '20'], 'Entrez un mot de passe (max = 8)');
        ToolsForm::input(['type'=> 'password','name'=> 'passwordConf','lenght' => '20'], 'Confirmez le mot de passe');
        ToolsForm::token('token_form', 'update');
        ToolsForm::token('originName', $donnees[0]->getUsername());
        ToolsForm::token('originEmail', $donnees[0]->getEmail());
        ToolsForm::token('token_csrf', FireWallController::tokenCSRF('protectedFormProfil'));
        ToolsForm::submit('Modifier');
        ?>
    </form>
</section>


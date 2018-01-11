<?php use App\Tools\ToolsForm;?>
<section class="registerPage">
    <?php if ($donnees[0]):?>
        <div class="alert alert-danger">
            <p><?php echo $donnees[0];?></p>
        </div>
    <?php endif; ?>
    <?php if ($donnees[1]):?>
        <div class="alert alert-success">
            <p><?php echo $donnees[1];?></p>
        </div>
    <?php endif; ?>
    <h4>Vous avez été redirigé vers cette page afin de vous inscrire ou vous connecter</h4>


    <!-- Partie caché à l'affichage initiale de la page -->
    <div id="modal-wrapper" class="modals">
        <div id="test"></div>
        <form id="idForm" class="modal-contents animate" method="post">
            <div class="imgcontainers ">
                <span id="imgContain" class="closes" title="Close PopUp">&times;</span>
                <h1 style="text-align:center">Inscription</h1>
            </div>
            <div class="containers ">
                <label for="fullname">Nom Complet</label>
                <input type="text" name="fullname" id="fullname" maxlength="20" required>
                <label for="username">Pseudo</label>
                <input type="text" name="username" id="username" maxlength="20" required>
                <label for="email">Email <span id="infoEmail"></span></label>
                <input type="text" name="email" id="email" maxlength="80" required>
                <label for="password">Entrez un mot de passe <span id="infoInput"></span></label>
                <input type="password" name="password" id="password" maxlength="20" required>
                <label for="passwordConf">Confirmez le mot de passe</label>
                <input type="password" name="passwordConf" id="passwordConf" maxlength="20" required>
                <input type="hidden" name="token_form" value="register">
                <input type="hidden" name="token_csrf" value="<?php echo ToolsForm::tokenCSRF('protectedForm')?>" >
                <input type="submit" value="Inscription">
            </div>
        </form>
    </div>
    <!-- Partie visible à l'affichage initiale de la page -->
    <div class="row">
        <div class="formulaire row">
            <p class="col-lg-12">Pas encore inscrit? Veuillez cliquer sur le bouton "Inscription".
                <button class="btnForm" id="formButton" >
                    Inscription
                </button>
            </p>

            <script src="/projet5/Public/src/js/popupForm.js"></script>
        </div>
    </div>
    <div id="modal-wrapper1 row">
        <form id="idConnect" class="modal-contents col-lg-6" method="post">
            <div class="imgcontainers ">
                <img src="/projet5/Public/src/images/avatar/1.png" alt="Avatar" class="avatars">
                <h1 style="text-align:center">Connection</h1>
            </div>
            <div class="containers">
                <label for="usernamelog">Pseudo</label>
                <input type="text" name="username" id="usernamelog" maxlength="20" required>
                <label for="passwordlog">Entrez votre mot de passe</label>
                <input type="password" name="password" id="passwordlog" maxlength="20" required>
                <input type="hidden" name="token_form" value="login">
                <input type="hidden" name="token_csrf" value="<?php echo ToolsForm::tokenCSRF('protectedForm')?>">
                <input type="submit" value="Connection" class="btnForm">
            </div>
        </form>
    </div>

</section>




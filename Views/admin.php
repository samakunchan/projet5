<?php
use App\Tools\ToolsForm;
use Controllers\FireWallController;

#Si une session en détecté, affiche la page
if (isset($_SESSION['username']) && $_SESSION['username']!==''):?>
    <!-- Si il existe un message de succès, affiche le message -->
    <?php if ($donnees[5]):?>
        <div class="alert alert-success">
            <p><?php echo $donnees[5];?></p>
        </div>
    <?php endif; ?><!-- Fin du message de succès -->

<section>
    <h1>Gestion des utilisateurs</h1>
    <!-- Bouton de retour vers l'espace membre -->
    <div class="btn btn-info">
        <a style="color: white; text-decoration: none" href="http://localhost/projet5/Public/memberArea/<?php echo $_SESSION['username']?>">Retour à l'espace membre</a>
    </div>
    <!-- Si une action de suppression est en cours, affiche la partie ci dessous -->
    <?php if ($donnees[4]):?>
        <?php if (isset($_POST['action']) && $_POST['action']==='conserver'): ?>
            <?php $donnees[4]=false ?>
            <?php else: ?>
        <div class="alert alert-danger row">
            <p>Confirmer la suppression de <?php echo $donnees[4]['fullname'];?> </p>
            <form method="post" class="col-lg-2">
                <input type="hidden" name="id" value="<?php echo $donnees[4]['id'];?>">
                <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedSuppression')?>">
                <input type="hidden" name="mode" value="delete">
                <input class="btn btn-danger" value="Supprimer" type="submit">
            </form>
            <form method="post" class="col-lg-2">
                <input type="hidden" name="action" value="conserver">
                <input class="btn btn-primary" value="Conserver" type="submit">
            </form>
        </div>
    <?php endif;?>
    <?php endif;?><!-- Fin de l'action de suppression -->

<!-- ADMINISTRATEUR -->
<div class="table-responsive">
    <table style="background-color: #868e96" class="panel-default table col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3>Administrateur</h3>
        <tr class="panel">
            <td>
                <p>Fullname</p>
            </td>
            <td>
                <p>Username</p>
            </td>
            <td>
                <p>Email</p>
            </td>
            <td>
                <p>Dates d'inscription</p>
            </td>
            <td>
                <p>Roles</p>
            </td>
            <td>
                <p>Action</p>
            </td>
        </tr>
        <!-- Affiche le résultat de tout les admins (il n'y a qu'un seul) -->
        <?php foreach ($donnees[1] as $donnee): ?>
            <tr>
                <td>
                    <?php echo $donnee->getFullname();?>
                </td>
                <td>
                    <?php echo $donnee->getUsername();?>
                </td>
                <td>
                    <?php echo $donnee->getEmail();?>
                </td>
                <td>
                    <?php echo $donnee->getDates();?>
                </td>
                <td>
                    <?php echo $donnee->getRoles();?>
                </td>
                <td>
                    NONE
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<!-- MODERATEUR -->
<div class="table-responsive">

    <table style="background-color: #919191" class="panel-default table col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3>Modérateur</h3>
        <tr class="panel tb2">
            <td><p>Fullname</p></td>
            <td><p>Username</p></td>
            <td><p>Email</p></td>
            <td><p>Dates d'inscription</p></td>
            <td><p>Dernière mise à jour</p></td>
            <td><p>Roles</p></td>
            <td><p>Action</p></td>
        </tr>
        <!-- Affiche le résultat de tout les modérateurs -->
        <?php foreach ($donnees[2] as $donnee): ?>
            <tr>
                <td><?php echo $donnee->getFullname();?></td>
                <td><?php echo $donnee->getUsername();?></td>
                <td><?php echo $donnee->getEmail();?></td>
                <td><?php echo $donnee->getDates();?></td>
                <td><?php echo $donnee->getLastedDate();?></td>
                <td>
                    <form method="post">
                        <select name="roles" id="roles">
                            <option name="ROLE_MODO" value="ROLE_MODO" selected>moderateur</option>
                            <option name="ROLE_USER" value="ROLE_USER">utilisateur</option>
                        </select>
                        <input type="hidden" name="username" value="<?php echo $donnee->getUsername();?>">
                        <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedRoles')?>">
                        <input type="hidden" name="mode" value="modif">
                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $donnee->getId();?>">
                        <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedSuppression')?>">
                        <input type="hidden" name="fullname" value="<?php echo $donnee->getFullname();?>">
                        <input type="hidden" name="mode" value="confirm">
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<!-- UTILISATEUR -->
<div class="table-responsive">
    <table style="background-color: #868e96" class="panel-default table tb3 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3>Utilisateur</h3>
        <tr class="panel tb3">
            <td>
                <p>Fullname</p>
            </td>
            <td>
                <p>Username</p>
            </td>
            <td>
                <p>Email</p>
            </td>
            <td>
                <p>Dates d'inscription</p>
            </td>
            <td><p>Dernière mise à jour</p></td>
            <td>
                <p>Roles</p>
            </td>
            <td>
                <p>Action</p>
            </td>
        </tr>
        <!-- Affiche le résultat de tout les utilisateurs -->
        <?php foreach ($donnees[3] as $donnee): ?>
            <tr>
                <td>
                    <?php echo $donnee->getFullname();?>
                </td>
                <td>
                    <?php echo $donnee->getUsername();?>
                </td>
                <td>
                    <?php echo $donnee->getEmail();?>
                </td>
                <td>
                    <?php echo $donnee->getDates();?>
                </td>
                <td><?php echo $donnee->getLastedDate();?></td>
                <td>
                    <form method="post">
                        <select name="roles" id="roles">
                            <option name="ROLE_MODO" value="ROLE_MODO">moderateur</option>
                            <option name="ROLE_USER" value="ROLE_USER" selected>utilisateur</option>
                        </select>
                        <input type="hidden" name="token_csrf" value="<?php echo FireWallController::tokenCSRF('protectedRoles')?>">
                        <input type="hidden" name="username" value="<?php echo $donnee->getUsername();?>">
                        <input type="hidden" name="mode" value="modif">
                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $donnee->getId();?>">
                        <input type="hidden" name="fullname" value="<?php echo $donnee->getFullname();?>">
                        <input type="hidden" name="mode" value="confirm">
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
</section>
<?php endif; ?><!-- Fin de l'affichage en fonction de la session -->

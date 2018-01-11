<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 13/12/2017
 * Time: 13:30
 */

namespace Controllers;
use App\Routing\Route;
use App\Tools\Views;
use Models\Manager\UsersManager;

/**
 * Class AdminController
 * @package Controllers
 * Class qui gère l'affichage de la page de gestion des utilisateurs (EXCLUSIVITE : ADMIN)
 */
class AdminController
{
    /**
     * @var Views
     * Contient "new Views('admin')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $manager;

    /**
     * @var FireWallController
     * Contient "new FireWallController($_POST)"
     * Reçoit directement le $post et l'envoie au controller FireWall
     */
    private $control;

    /**
     * AdminController constructor.
     * Stock "new Views('admin')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new FireWallController($_POST)" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('admin');
        $this->manager = new UsersManager();
        $this->control = new FireWallController($_POST);

    }

    /**
     * Méthode qui :
     * construit la page "admin",
     * Ouvre une session
     * Si il reçoit des données $post, il fait des controls avec le FireWall
     * Il control le rôle de l'utilisateur connecter
     */
    public function buildAdminPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->control->fireWallMode();
            }
        }
        if ($_SESSION){
            if (isset($_SESSION['username']) && $_SESSION['username'] !==''){
                $result = $this->manager->read($_SESSION['username']);
                if ($result->getRoles()=== 'ROLE_ADMIN'){
                    $data = $this->manager->readAll();
                    $roleAdmin = $this->manager->readRoles('ROLE_ADMIN');
                    $roleModo = $this->manager->readRoles('ROLE_MODO');
                    $roleUser = $this->manager->readRoles('ROLE_USER');
                    $this->view->genererPages(
                        [
                            $data,
                            $roleAdmin,
                            $roleModo,
                            $roleUser,
                            FireWallController::confirmDelete(),
                            FireWallController::messageSuccess(),
                        ]
                    );
                }else{
                    header('HTTP/1.0 403 Forbidden');
                    die('<p class="introuvable" style="font-size: 100px;text-align: center; margin-top: 80px;">Accès interdit</p>');
                }
            }
        }else{
            Route::redirection('register');
        }

    }
}
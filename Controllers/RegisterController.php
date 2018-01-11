<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 12/12/2017
 * Time: 10:00
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;

/**
 * Class RegisterController
 * @package Controllers
 * Class qui gère l'affichage du formulaire d'inscription et de connection
 */
class RegisterController
{
    /**
     * @var Views
     * Contient "new Views('register')"
     */
    private $view;

    /**
     * @var FireWallController
     * Contient "new FireWallController($_POST)"
     */
    private $control;

    /**
     * RegisterController constructor.
     * Stock "new Views('register')" dans on attribut
     * Stock "new FireWallController($_POST)" dans on attribut
     */
    public function __construct()
    {
        $this->view = new Views('register');
        $this->control = new FireWallController($_POST);
    }

    /**
     * Méthode qui construit la page d'affichage des formulaires
     * Si il reçoit des données de type $post, il lance le FireWall avec sa méthode "$this->control->action()"
     */
    public function buildRegisterPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->control->action();
            }
        }
        $this->view->genererPages([FireWallController::messageFlashForm(), FireWallController::messageSuccess()]);
    }
}

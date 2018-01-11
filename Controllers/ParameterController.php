<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 15/12/2017
 * Time: 17:00
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Users;
use Models\Manager\UsersManager;

/**
 * Class ParameterController
 * @package Controllers
 * Class qui gère le paramètrage (la modification) des données intrinsèque d'utilisateur (Reservé : utilisateur lui-même)
 */
class ParameterController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('parameter')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $manager;

    /**
     * @var Users
     * Contient "new Users()"
     */
    private $user;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $msg;

    /**
     * @var
     * Contient le message de succes
     */
    private static $success;

    /**
     * ParameterController constructor.
     * Stock "new Views('parameter')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new Users()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('parameter');
        $this->manager = new UsersManager();
        $this->user = new Users();
    }

    /**
     * Méthode qui :
     * Construit la page des paramètres utilisateur
     * Ouvre une session
     * Lis les données utilisateur depuis l'id reçut en $get
     * Si il reçoit des données de type $post, il lance la méthode "updateProfil()"
     */
    public function buildParameterPage()
    {
        if ($_POST){
            $this->updateProfil();
        }
        if ($_SESSION){
            if (isset($_SESSION['username']) && $_SESSION['username'] !=='' ){
                $result = $this->manager->read($_SESSION['username']);
                if (isset($_GET['id']) && !empty($_GET['id']) &&
                    isset($_GET['action']) && !empty($_GET['action'])){
                    $this->view->genererPages([$result, self::messageErrorProfil(), self::messageSuccessProfil()]);
                }
            }
        }else{
            header('HTTP/1.0 403 Forbidden');
            die('<p class="introuvable" style="font-size: 100px;text-align: center; margin-top: 80px;">Accès interdit</p>');
        }
    }

    /**
     * @return bool
     * Méthode qui gère la mise à jour des données du profil utilisateur
     * Control si le nouvel "username" est déjà existant dans la BDD
     * Control si le nouvel "email" est déjà existant dans la BDD
     */
    public function updateProfil()
    {
        if (isset($_POST['fullname']) && !empty($_POST['fullname']) &&
            isset($_POST['username']) && !empty($_POST['username']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password']) && !empty($_POST['password']) &&
            isset($_POST['passwordConf']) && !empty($_POST['passwordConf'] &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf']) &&
            isset($_POST['originName']) && !empty($_POST['originName']))){

            if ($_POST['originName'] !== $_POST['username']) {
                $userAlreadyExist = $this->manager->read($_POST['username']);
                if ($userAlreadyExist) {
                    self::$msg = 'Utilisateur ' . $_POST['username'] . ' déja éxistant.';
                    return false;
                }
            }elseif ($_POST['originEmail'] !== $_POST['email']){
                $emailAlreadyExist = $this->manager->readEmail($_POST['email']);
                if ($emailAlreadyExist){
                    self::$msg = 'Email '.$_POST['email'].' déja éxistant.';
                    return false;
                }
            }

            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormProfil')) {
                if ($_POST['password'] !== $_POST['passwordConf']) {
                    self::$msg = 'Erreur : Les mots de passe doivent être identique.';
                    return false;
                }else{
                    $this->user->setFullname($_POST['fullname']);
                    $this->user->setUsername($_POST['username']);
                    $this->user->setEmail($_POST['email']);
                    $this->user->setPassword([$_POST['password'], $_POST['passwordConf']]);
                    $this->manager->update($this->user);
                    self::$success = 'Les données ont bien été mis à jours.';
                }
            }
        }else{
            self::$msg = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous de "string"
     */
    private static function messageErrorProfil()
    {
        return self::$msg;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous de "string"
     */
    private static function messageSuccessProfil()
    {
        return self::$success;
    }
}
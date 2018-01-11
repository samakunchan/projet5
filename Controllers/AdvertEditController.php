<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 20/12/2017
 * Time: 14:32
 */

namespace Controllers;


use App\Routing\Route;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Adverts;
use Models\Manager\AdvertManager;
use Models\Manager\UsersManager;

/**
 * Class AdvertEditController
 * @package Controllers
 * Class qui gère la modification et la mise à jour des données
 */
class AdvertEditController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('advertEdit')"
     */
    private $view;

    /**
     * @var AdvertManager
     * Contient "new AdvertManager()"
     */
    private $advertManager;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var Adverts
     * Contient "new Adverts()"
     */
    private $advert;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $error;

    /**
     * @var
     * Contient le message de succes
     */
    private static $success;

    /**
     * AdvertEditController constructor.
     * Stock "new Views('advertEdit')" dans son attribut
     * Stock "new AdvertManager()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new Adverts()"" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('advertEdit');
        $this->advertManager = new AdvertManager();
        $this->userManager = new UsersManager();
        $this->advert = new Adverts();
    }

    /**
     * Méthode qui :
     * Contruit la page de modification des annonces
     * Ouvre une session
     * Si il reçoit une annonce modifié, il lance la méthode de modification "modifAdvert()"
     */
    public function buildAdvertEditPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->modifyAdvert();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                if ($_GET){
                    if (isset($_GET['id']) && !empty($_GET['id']) &&
                        isset($_GET['page']) && !empty($_GET['page']) &&
                        isset($_GET['title']) && !empty($_GET['title'])){
                        $resultAdvert = $this->advertManager->read($_GET['id']);
                        $resultUser = $this->userManager->read($_SESSION['username']);
                        if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                            $resultUser->getRoles()=== 'ROLE_MODO'){
                            $this->view->genererPages([$resultUser, $resultAdvert, self::messageErrorAdvert(), self::messageSuccessAdvert()]);
                        }else{
                            header('HTTP/1.0 403 Forbidden');
                            die('<p class="introuvable" style="font-size: 100px;text-align: center; margin-top: 80px;">Accès interdit</p>');
                        }
                    }
                }
            }
        }else{
            Route::redirection('register');
        }
    }

    /**
     * Méthode qui reçoit les données et les mets à jours
     */
    public function modifyAdvert()
    {
        if (isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormAdvertEdit')){
                $this->advert->setTitle($_POST['title']);
                $this->advert->setContent($_POST['content']);
                $titleForUrl = str_replace(' ', '-', $_POST['title']);
                $this->advert->setUrl(strtolower($titleForUrl));
                $this->advertManager->update($this->advert);
                self::$success = 'Votre annonce a été modifié et mis à jours.';
            }else{
                self::$error = 'Un problème est survenu lors de la modification de votre annonce';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous forme de "string"
     */
    private static function messageErrorAdvert()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme de "string"
     */
    private static function messageSuccessAdvert()
    {
        return self::$success;
    }
}
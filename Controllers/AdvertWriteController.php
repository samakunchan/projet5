<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 19/12/2017
 * Time: 00:02
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Adverts;
use Models\Manager\AdvertManager;
use Models\Manager\UsersManager;
use App\Routing\Route;

/**
 * Class AdvertWriteController
 * @package Controllers
 * Class qui gère la création d'une annonce (réservé à l'admin et aux modos)
 */
class AdvertWriteController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('advertWrite')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var AdvertManager
     * Contient "new AdvertManager()"
     */
    private $advertManager;

    /**
     * @var Adverts
     * Contient "new Adverts()"
     */
    private $advert;

    /**
     * @var
     * Contient le message de succes
     */
    private static $msg;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $success;

    /**
     * AdvertWriteController constructor.
     * Stock "new Views('advertWrite')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new AdvertManager()" dans son attribut
     * Stock "new Adverts()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('advertWrite');
        $this->userManager = new UsersManager();
        $this->advertManager = new AdvertManager();
        $this->advert = new Adverts();
    }

    /**
     * Méthode qui :
     * Construit la page de la création d'un annonce
     * Ouvre une session
     * Controle l'accessibilité de la page (réservé à l'admin et aux modos)
     * Si il reçoit des données de type $post, il lance la méthode "publisAdvert()"
     */
    public function buildAdvertWritePage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->publishAdvert();
            }
        }
        
        if ($_SESSION){
         if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $result = $this->userManager->read($_SESSION['username']);
             if ($result->getRoles()=== 'ROLE_ADMIN' ||
                 $result->getRoles()=== 'ROLE_MODO'){
                 $this->view->genererPages([$result, self::messageErrorAdvert(), self::messageSuccessAdvert()]);
             }else{
                 header('HTTP/1.0 403 Forbidden');
                 die('<p class="introuvable" style="font-size: 100px;text-align: center; margin-top: 80px;">Accès interdit</p>');
             }
            }
        }else{
            Route::redirection('register');
        }
    }

    /**
     * Méthode qui gère la création de l'annonce et l'envoie la dans BDD
     */
    public function publishAdvert()
    {
        if (isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormAdvert')){
                $this->advert->setTitle($_POST['title']);
                $this->advert->setContent($_POST['content']);
                $titleForUrl = str_replace(' ', '-', $_POST['title']);
                $this->advert->setUrl(strtolower($titleForUrl));
                $this->advertManager->create($this->advert);
                self::$success = 'Votre annonce a été publié.';
            }else{
                self::$msg = 'Un problème est survenu lors de la création de votre annonce';
            }
        }else{
            self::$msg = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous de "string"
     */
    private static function messageErrorAdvert()
    {
        return self::$msg;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous de "string"
     */
    private static function messageSuccessAdvert()
    {
        return self::$success;
    }
}
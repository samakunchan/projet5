<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 20/12/2017
 * Time: 02:05
 */

namespace Controllers;


use App\Routing\Route;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Adverts;
use Models\Manager\AdvertManager;
use Models\Manager\UsersManager;

/**
 * Class AdvertListController
 * @package Controllers
 * Class qui gère le listing des annonces (Réservé à l'admin et modo)
 */
class AdvertListController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('advertList')"
     */
    private $views;

    /**
     * @var AdvertManager
     * Contient "new AdvertManager()"
     */
    private $advertManager;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $usersManager;

    /**
     * @var Adverts
     * Contient "new Adverts()"
     */
    private $advert;

    /**
     * @var AdvertEditController
     * Contient "new AdvertEditController()"
     */
    private $managingData;

    /**
     * AdvertListController constructor.
     * Stock "new Views('advertList')" dans son attribut
     * Stock "new AdvertManager()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new Adverts()" dans son attribut
     * Stock "new AdvertEditController()" dans son attribut
     */
    public function __construct()
    {
        $this->views = new Views('advertList');
        $this->advertManager = new AdvertManager();
        $this->usersManager = new UsersManager();
        $this->advert = new Adverts();
        $this->managingData = new AdvertEditController();
    }

    /**
     * Méthode qui :
     * Contruit la page du listing des toutes les annonces
     * Page réservé a l'admin et aux modos
     * Ouvre une session
     * Reçoit des données de type post pour "supprimer" ou "modifier" une annonce.
     */
    public function buildAdvertListPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->selectMode();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $resultAdvert = $this->advertManager->readAll();
                $resultUser = $this->usersManager->read($_SESSION['username']);
                if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                    $resultUser->getRoles()=== 'ROLE_MODO'){
                    $this->views->genererPages([$resultUser, $resultAdvert, self::confirmDeleteAdvert()]);
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
     * Méthode qui gère la suppression et la modification d'un annonce
     */
    public function selectMode()
    {
        if (isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['mode']) && !empty($_POST['mode']) &&
            isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($_POST['mode']=== 'confirmer'){
                if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedAdvertSuppression')){
                    self::confirmDeleteAdvert();
                }else{
                    echo "test";
                }
            }elseif ($_POST['mode']=== 'supprimer'){
                $this->advertManager->delete($_POST['id']);
                $delai=1;
                $url='http://localhost/projet5/Public/advert-list';
                header("Refresh: $delai;url=$url");
            }
        }
    }

    /**
     * @return mixed
     * Méthode static qui renvoie les données reçues si la suppression de l'annonce est confirmé.
     */
    public static function confirmDeleteAdvert()
    {
        if (isset($_POST['mode']) && !empty($_POST['mode'] ) &&
            isset($_POST['id']) && !empty($_POST['id'] ) &&
            isset($_POST['title']) && !empty($_POST['title'] ) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            return $_POST;
        }
    }

}
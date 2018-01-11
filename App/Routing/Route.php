<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 18:00
 */

namespace App\Routing;

use Controllers\AboutController;
use Controllers\AdminController;
use Controllers\AdvertController;
use Controllers\AdvertEditController;
use Controllers\AdvertListController;
use Controllers\AdvertWriteController;
use Controllers\CalendarController;
use Controllers\CategoryController;
use Controllers\CategoryEditController;
use Controllers\CategoryWriteController;
use Controllers\CategorySingleController;
use Controllers\CommentEditController;
use Controllers\HomeController;
use Controllers\MediaController;
use Controllers\MemberAreaController;
use Controllers\ParameterController;
use Controllers\PartyController;
use Controllers\PropositionPartyController;
use Controllers\PropositionPartyEditController;
use Controllers\RegisterController;
use Controllers\ShowController;
use Controllers\SignalController;

/**
 * Class Route
 * @package App\Routing
 * Class qui gère le routing des pages
 */
class Route
{
    /**
     * @var HomeController
     */
    private $homepage;

    /**
     * @var RegisterController
     */
    private $register;

    /**
     * @var AdvertController
     */
    private $advert;

    /**
     * @var CategoryController
     */
    private $category;

    /**
     * @var CategoryWriteController
     */
    private $categoryWrite;

    /**
     * @var CategoryEditController
     */
    private $categoryEdit;

    /**
     * @var CategorySingleController
     */
    private $categorySingle;

    /**
     * @var MemberAreaController
     */
    private $memberArea;

    /**
     * @var AdminController
     */
    private $admin;

    /**
     * @var ParameterController
     */
    private $parameter;

    /**
     * @var AdvertWriteController
     */
    private $advertWrite;

    /**
     * @var AdvertEditController
     */
    private $advertEdit;

    /**
     * @var AdvertListController
     */
    private $advertList;

    /**
     * @var PropositionPartyController
     */
    private $propositionParty;

    /**
     * @var PropositionPartyEditController
     */
    private $propositionPartyEdit;

    /**
     * @var PartyController
     */
    private $party;

    /**
     * @var ShowController
     */
    private $show;

    /**
     * @var CommentEditController
     */
    private $commentEdit;

    /**
     * @var SignalController
     */
    private $signals;

    /**
     * @var AboutController
     */
    private $about;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->homepage= new HomeController();
        $this->register= new RegisterController();
        $this->advert = new AdvertController();
        $this->category = new CategoryController();
        $this->categoryWrite = new CategoryWriteController();
        $this->categoryEdit = new CategoryEditController();
        $this->categorySingle = new CategorySingleController();
        $this->memberArea = new MemberAreaController();
        $this->admin = new AdminController();
        $this->parameter = new ParameterController();
        $this->advertWrite = new AdvertWriteController();
        $this->advertEdit = new AdvertEditController();
        $this->advertList = new AdvertListController();
        $this->propositionParty = new PropositionPartyController();
        $this->propositionPartyEdit = new PropositionPartyEditController();
        $this->party = new PartyController();
        $this->show = new ShowController();
        $this->commentEdit = new CommentEditController();
        $this->signals = new SignalController();
        $this->about = new AboutController();
    }

    /**
     * Méthode qui affiche par défaut la page d'acceuil
     * Il reçoit les requetes des pages sous forme de $get
     * Redirige vers le controlleru adapter selon la page demander
     */
    public function start()
    {
        if(isset($_GET['page'])){
            $pages = $_GET['page'];
        }else{
            $pages = 'home';
        }
        $this->gestionPages($pages);
    }

    /**
     * Méthode qui control le type de page appelé et redirige vers le controlleur adapté
     */
    public function gestionPages($pages)
    {
        switch ($pages){
            case 'home':
                $this->homepage->buildHomePage();
                break;
            case 'register':
                $this->register->buildRegisterPage();
                break;
            case 'advert':
                $this->advert->buildAdvertPage();
                break;
            case 'category':
                $this->category->buildCategoryPage();
                break;
            case 'admin':
                $this->admin->buildAdminPage();
                break;
            case 'memberArea':
                $this->memberArea->buildMemberAreaPage();
                break;
            case 'logout':
                session_destroy();
                Route::redirection('home');
                break;
            case 'parameter':
                $this->parameter->buildParameterPage();
                break;
            case 'advertWrite':
                $this->advertWrite->buildAdvertWritePage();
                break;
            case 'propositionParty':
                $this->propositionParty->buildPropositionPartyPage();
                break;
            case 'propositionPartyEdit':
                $this->propositionPartyEdit->buildPropositionPartyEditPage();
                break;
            case 'party':
                $this->party->buildPartyPage();
                break;
            case 'advertList':
                $this->advertList->buildAdvertListPage();
                break;
            case 'advertEdit':
                $this->advertEdit->buildAdvertEditPage();
                break;
            case 'show':
                $this->show->buildShowPage();
                break;
            case 'categorySingle':
                $this->categorySingle->buildCategorySinglePage();
                break;
            case 'categoryWrite':
                $this->categoryWrite->buildCategoryEdit();
                break;
            case 'categoryEdit':
                $this->categoryEdit->buildCategoryEditController();
                break;
            case 'commentEdit':
                $this->commentEdit->buildCommentEditPage();
                break;
            case 'signals':
                $this->signals->buildSignalsPage();
                break;
            case 'about':
                $this->about->buildAboutPage();
                break;
            default: 'La page n\'existe pas';
        }
    }

    /**
     * Méthode static qui permet les redirections dynamiques
     */
    public static function redirection($pages)
    {
        header('Location: '.$pages.' ');
        exit();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 13/12/2017
 * Time: 13:27
 */

namespace Controllers;
use App\Tools\Views;
use Models\Manager\CategoryManager;
use Models\Manager\UsersManager;

/**
 * Class CategoryController
 * @package Controllers
 * Clas qui gère l'affichage de toute les catégories
 */
class CategoryController
{
    /**
     * @var Views
     * Contient "Views('category')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $categoryManager;

    /**
     * CategoryController constructor.
     * Stock "Views('category')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('category');
        $this->userManager = new UsersManager();
        $this->categoryManager = new CategoryManager();
    }

    /**
     * Méthode qui :
     * Construit la page catégorie
     * Ouvre une session
     * Envoie dans la vue des données user afin faire un control des droits de modification
     */
    public function buildCategoryPage()
    {
        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $user = $this->userManager->read($_SESSION['username']);
                $result = $this->categoryManager->readAll();
                $this->view->genererPages([$result, $user]);
            }
        }else{
            $result = $this->categoryManager->readAll();
            $this->view->genererPages($result);
        }
    }
}
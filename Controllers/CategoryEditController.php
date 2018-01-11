<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 23/12/2017
 * Time: 00:20
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Category;
use Models\Manager\CategoryManager;
use App\Routing\Route;
use Models\Manager\UsersManager;

/**
 * Class CategoryEditController
 * @package Controllers
 * Class qui gère la modification des catégories (réservé a l'admin et aux modos)
 */
class CategoryEditController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('categoryEdit')"
     */
    private $view;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $manager;

    /**
     * @var Category
     * Contient "new Category()"
     */
    private $category;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

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
     * CategoryEditController constructor.
     * Stock "new Views('categoryEdit')" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     * Stock "new Category()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('categoryEdit');
        $this->manager = new CategoryManager();
        $this->category = new Category();
        $this->userManager = new UsersManager();
    }

    /**
     * Méthode qui :
     * Construit la page de la modification des catégories
     * Control l'accessibilité a cette page (réservé a l'admin et aux modos)
     * Ouvre une session
     * Si il reçoit des données de type $post, il lance la méthode "modifyCategory()"
     */
    public function buildCategoryEditController()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->modifyCategory();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                if ($_GET){
                    if (isset($_GET['id']) && !empty($_GET['id']) &&
                        isset($_GET['page']) && !empty($_GET['page'])){
                        $resultCat = $this->manager->read($_GET['id']);
                        $resultUser = $this->userManager->read($_SESSION['username']);
                        if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                            $resultUser->getRoles()=== 'ROLE_MODO'){
                            $this->view->genererPages([$resultUser, $resultCat,self::messageErrorCategory(), self::messageSuccessCategory()]);
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
     * Méthode qui gère la modification et la mise à jours des données dans la BDD
     */
    public function modifyCategory()
    {
        if (isset($_POST['cat_name']) && !empty($_POST['cat_name']) &&
            isset($_POST['description']) && !empty($_POST['description']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){//mettre le token
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedCategoryEdit')){
                $this->category->setCatName($_POST['cat_name']);
                $this->category->setDescription($_POST['description']);
                $catForUrl = str_replace(' ', '-', $_POST['cat_name']);
                $this->category->setUrlCat(strtolower($catForUrl));
                $this->manager->update($this->category);
                self::$success = 'Vos données ont été mis à jours.';
            }else{
                self::$error = 'Un problème est survenu lors de la modification de votre catégorie';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous de "string"
     */
    private static function messageErrorCategory()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous de "string"
     */
    private static function messageSuccessCategory()
    {
        return self::$success;
    }
}
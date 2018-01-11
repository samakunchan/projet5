<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 22/12/2017
 * Time: 17:43
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Category;
use Models\Manager\CategoryManager;
use Models\Manager\UsersManager;
use App\Routing\Route;

/**
 * Class CategoryWriteController
 * @package Controllers
 * Class qui gère la création d'une catégorie (réservé a l'admin et aux modos)
 */
class CategoryWriteController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('categoryWrite')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var Category
     * Contient "new Category()"
     */
    private $category;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $categoryManager;
    private static $error;
    private static $success;

    /**
     * CategoryWriteController constructor.
     * Stock "new Views('categoryWrite')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new Category()" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('categoryWrite');
        $this->userManager = new UsersManager();
        $this->category = new Category();
        $this->categoryManager = new CategoryManager();
    }

    /**
     * Méthode qui :
     * Construit la page de la création d'une catégorie
     * Control l'accessibilité de la page (réservé a l'admin et aux modos)
     * Ouvre un session
     * Si il reçoit des données de type $post, il lance la méthode "addNewCategory()"
     */
    public function buildCategoryEdit()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->addNewCategory();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $result = $this->userManager->read($_SESSION['username']);
                if ($result->getRoles()=== 'ROLE_ADMIN' ||
                    $result->getRoles()=== 'ROLE_MODO'){
                    $this->view->genererPages([$result, self::messageErrorCategory(), self::messageSuccessCategory()]);
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
     * Méthode qui gère la création d'une catégorie
     */
    public function addNewCategory()
    {
        if (isset($_POST['cat_name']) && !empty($_POST['cat_name']) &&
            isset($_POST['description']) && !empty($_POST['description']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){//mettre le token
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedCategoryEdit')){
                $this->category->setCatName($_POST['cat_name']);
                $this->category->setDescription($_POST['description']);
                $catForUrl = str_replace(' ', '-', $_POST['cat_name']);
                $this->category->setUrlCat(strtolower($catForUrl));
                $this->categoryManager->create($this->category);
                self::$success = 'Vous avez créé une nouvelle catégorie.';
            }else{
                self::$error = 'Un problème est survenu lors de la création de votre catégorie';
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
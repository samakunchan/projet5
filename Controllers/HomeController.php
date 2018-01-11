<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 18:05
 */

namespace Controllers;
use App\Tools\Views;
use Models\Manager\UsersManager;

/**
 * Class HomeController
 * @package Controllers
 * Class qui gère l'affichage de la page d'acceuil
 */
class HomeController
{
    /**
     * @var Views
     * Contient "new Views('home')"
     */
    private $view;

    /**
     * HomeController constructor.
     * Stock "new Views('home')" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('home');
    }

    /**
     * Méthode qui construit la page d'acceuil
     */
    public function buildHomePage()
    {
         $this->view->genererPages();

    }
}
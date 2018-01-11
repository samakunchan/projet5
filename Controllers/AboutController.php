<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 06/01/2018
 * Time: 00:17
 */

namespace Controllers;
use App\Tools\Views;

/**
 * Class AboutController
 * @package Controllers
 * Page qui gère l'affichage de la page "A propos"
 */
class AboutController
{
    /**
     * Attribut qui contient "new Views('about')"
     * @var Views
     */
    private $view;

    /**
     * AboutController constructor.
     * Stock "new Views('about')" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('about');
    }

    /**
     * Méthode public qui contruit la page "a propos"
     */
    public function buildAboutPage()
    {
        $this->view->genererPages();
    }
}
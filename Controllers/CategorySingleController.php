<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 22/12/2017
 * Time: 02:42
 */

namespace Controllers;
use App\Tools\Views;
use Models\Manager\CategoryManager;
use Models\Manager\PropositionPartyManager;

/**
 * Class CategorySingleController
 * @package Controllers
 * Class qui gère l'affichage d'un type de catégorie particulier
 */
class CategorySingleController
{
    /**
     * @var Views
     * Contient "new Views('categorySingle')"
     */
    private $view;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $propositionManager;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $categoryManager;

    /**
     * CategorySingleController constructor.
     * Stock "new Views('categorySingle')" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('categorySingle');
        $this->propositionManager = new PropositionPartyManager();
        $this->categoryManager = new CategoryManager();
    }

    /**
     * Méthode qui :
     * Reçoit l'id de la catégorie en $get
     * Lis l'id de la catégorie
     * Contruit la page d'affichage d'un type de catégorie
     */
    public function buildCategorySinglePage()
    {
        if (isset($_GET['id']) && !empty($_GET['id']) &&
            isset($_GET['title']) && !empty($_GET['title'])){
            $result = $this->propositionManager->readAllSpeCaT($_GET['id']);
            if ($result){
                $resultCat = $this->categoryManager->read($result[0]->getCatId());
                $this->view->genererPages([$result, $resultCat]);
            }else{
                $this->view->genererPages();
            }
        }
    }

}
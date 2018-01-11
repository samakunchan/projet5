<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 20/12/2017
 * Time: 01:19
 */

namespace Controllers;
use App\Tools\Views;
use Models\Entity\PropositionParty;
use Models\Manager\PropositionPartyManager;

/**
 * Class PartyController
 * @package Controllers
 * Class qui gère l'affichage des JDR créés
 */
class PartyController
{
    /**
     * @var Views
     * Contient "new Views('party')"
     */
    private $views;

    /**
     * @var PropositionParty
     * Contient "new PropositionParty()"
     */
    private $party;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $managerPart;

    /**
     * @var
     * Contient le numéro de la page actuel. Type $get
     */
    private $actualPage;

    /**
     * @var
     * Contient le message de succes
     */
    private static $success;

    /**
     * PartyController constructor.
     * Stock "new Views('party')" dans son attribut
     * Stock "new PropositionParty()" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     */
    public function __construct()
    {
        $this->views = new Views('party');
        $this->party = new PropositionParty();
        $this->managerPart = new PropositionPartyManager();
    }

    /**
     * Méthode qui :
     * Construit la page d'affichage des JDR
     * Si il reçoit des données de type $post, il lance la méthode "signalParty()" pour effectuer le signalement
     */
    public function buildPartyPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->signalParty();
            }
        }
        if (isset($_GET['page']) && !empty($_GET['page'])){
            if (isset($_GET['p']) && $_GET['p']>0 && $_GET['p']<= self::nombreArticlesParPages()){
                $this->actualPage = $_GET['p'];
            }else{
                $this->actualPage= 1;
            }
            $result = $this->managerPart->readAll($this->actualPage, self::articlesParPages());
            $this->views->genererPages([$result, self::messageSuccessForm()]);
        }else{
            die("La page que vous demandez n'existe pas");
        }
    }

    /**
     * Méthode static pour avoir dynamiquement le nombre d'articles par page
     */
    public static function articlesParPages($nb= 5)
    {
        return $nb;
    }

    /**
     * Méthode static pour avoir dynamiquement le nombre total des chapitres
     */
    public static function total()
    {
        $donnees = new PropositionPartyManager();
        $res = $donnees->readAll();
        return count($res);
    }

    /**
     * Méthode static pour avoir dynamiquement le nombre total de page sur 8 qu'il faudrait pour tout les articles
     */
    public static function nombreArticlesParPages()
    {
        return ceil(self::total()/self::articlesParPages());
    }

    /**
     * Méthode static pour avoir dynamiquement une vue la page actuel/nombre de page total
     * Situer en "suivant et "précédente
     */
    public static function pageActuel()
    {
        if (isset($_GET['p']) && !empty($_GET['p'])){
            if ($_GET['p']>self::nombreArticlesParPages()){
                return '<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-8 col-sm-8 col-md-8 col-lg-8 btn btn-secondary pageActuel">Cette page n\'existe pas </span>';
            }
            return '<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-secondary pageActuel">'.$_GET['p'].'/'.self::nombreArticlesParPages().' </span>';
        }
        return '<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 btn btn-secondary pageActuel">1/'.self::nombreArticlesParPages().' </span>';
    }

    /**
     * Méthode static pour avoir dynamiquement le bouton "suivant" en fonction des circonstances
     */
    public static function suivante()
    {
        if (isset($_GET['p'])){
            if (isset($_GET['page']) && $_GET['page']==='party' ){
                if ($_GET['p']<self::nombreArticlesParPages()){
                    $p = $_GET['p']+1;
                    return '<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-3 col-sm-3 col-md-3 col-lg-3 btn btn-primary">
<a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/party/page-'.$p.'"> Suivante</a>
</span>';
                }
            }
        }elseif (!isset($_GET['p'])){
            if (isset($_GET['page']) && $_GET['page']==='party' ){
                return '<span class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-3 col-sm-3 col-md-3 col-lg-3 btn btn-primary">
<a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/party/page-2"> Suivante</a>
</span>';
            }
        }

    }

    /**
     * Méthode static pour avoir dynamiquement le bouton "précédente" en fonction des circonstances
     */
    public static function precedente()
    {
        if (isset($_GET['p'])){
            if (isset($_GET['page']) && $_GET['page']==='party'){
                if ($_GET['p']<=1){
                    $p = 1;
                    return '<span class="col-xs-3 col-sm-3 col-md-3 col-lg-3 btn btn-primary"><a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/party/page-'.$p.'">Précédente </a></span>';
                }elseif ($_GET['p']<=self::nombreArticlesParPages()){
                    $p = $_GET['p']-1;
                    return '<span class="col-xs-3 col-sm-3 col-md-3 col-lg-3 btn btn-primary"><a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/party/page-'.$p.'"> Précédente</a></span>';
                }
            }
        }elseif (isset($_GET['p'])){
            if (isset($_GET['page']) && $_GET['page']==='party'){
                return '<span class="col-xs-3 col-sm-3 col-md-3 col-lg-3 btn btn-primary"><a style="color: white; text-decoration: none;" href="http://localhost/projet5/Public/party/page-1"> Précédente</a></span>';
            }
        }
    }


    public function signalParty()
    {
        if (isset($_POST['part_id']) && !empty($_POST['part_id'])){
            $this->party->setSignals(1);
            $this->managerPart->updateSignaler($this->party, $_POST['part_id']);
            self::$success = 'Vous avez signalé cette partie. Merci de votre implication.';
        }
    }

    public static function messageSuccessForm()
    {
        return self::$success;
    }
}
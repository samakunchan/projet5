<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 26/12/2017
 * Time: 21:52
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Comments;
use Models\Entity\PropositionParty;
use Models\Manager\CommentsManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\UsersManager;
use App\Routing\Route;
use Models\Entity\DialogSpace;
use Models\Manager\DialogSpaceManager;

/**
 * Class SignalController
 * @package Controllers
 * Class qui gère l'affichage de la gestion des signalements des parties,
 * des commentaires-annonces, des commentaires-jdr
 */
class SignalController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('signals')"
     */
    private $view;

    /**
     * @var Comments
     * Contient "new Comments()"
     */
    private $comment;

    /**
     * @var PropositionParty
     * Contient "new PropositionParty()"
     */
    private $party;

    /**
     * @var CommentsManager
     * Contient "CommentsManager()"
     */
    private $managerCom;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $managerPart;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var DialogSpace
     * Contient "new DialogSpace()"
     */
    private $dialog;

    /**
     * @var DialogSpaceManager
     * Contient "new DialogSpaceManager()"
     */
    private $dialogManager;

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
     * SignalController constructor.
     * Stock "new Views('signals')" dans son attribut
     * Stock "new Comments()" dans son attribut
     * Stock "new PropositionParty()" dans son attribut
     * Stock "new CommentsManager()" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new DialogSpace()" dans son attribut
     * Stock "new DialogSpaceManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('signals');
        $this->comment = new Comments();
        $this->party = new PropositionParty();
        $this->managerCom = new CommentsManager();
        $this->managerPart = new PropositionPartyManager();
        $this->userManager = new UsersManager();
        $this->dialog = new DialogSpace();
        $this->dialogManager = new DialogSpaceManager();
    }

    /**
     * Méthode qui :
     * Construit la page de la gestion des signalements
     * Reçoit les données de type $post et lance les méthodes en conséquence.
     */
    public function buildSignalsPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                if (isset($_POST['mode']) && !empty($_POST['mode'])){
                    if ($_POST['mode'] === 'conserverCom'){
                        $this->converseComSignals();
                    }elseif ($_POST['mode'] === 'supprimerCom'){
                        $this->deleteComSignals();
                    }elseif ($_POST['mode'] === 'conserverPart'){
                        $this->conservePartSignals();
                    }elseif ($_POST['mode'] === 'supprimerPart'){
                        $this->deletePartSignals();
                    }elseif ($_POST['mode'] === 'conserverPartCOM'){
                        $this->conservePartCOMSignals();
                    }elseif ($_POST['mode'] === 'supprimerPartCOM'){
                        $this->deletePartCOMSignals();
                    }
                }
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $resultCom = $this->managerCom->readAllSignalement();
                $resultPart = $this->managerPart->readAllSignalement();
                $resultDialog = $this->dialogManager->readAllSignalement();
                $resultUser = $this->userManager->read($_SESSION['username']);
                if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                    $resultUser->getRoles()=== 'ROLE_MODO'){
                    $this->view->genererPages([$resultUser, $resultCom, $resultPart, self::messageErrorForm(), self::messageSuccessForm(), $resultDialog]);
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
     * Méthode qui met à jours les signalements (annonce) afin de récupérer le commentaire
     */
    public function converseComSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $this->comment->setSignals(2);
            $this->managerCom->updateSignaler($this->comment, $_POST['id']);
            self::$success = 'Récupération du commentaire';
        }else{
            self::$error = 'Un problème est survenu lors de la récupération du commentaire';
        }
    }

    /**
     * Méthode qui met à jours les signalements (annonce) afin de supprimer le commentaire
     */
    public function deleteComSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'SuppressComment')){
                $this->managerCom->delete($_POST['id']);
                self::$success = 'Suppression du commentaire';
            }else{
                self::$error = 'Un problème est survenu lors de la suppression du commentaire com';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * Méthode qui met à jours les signalements (partie) afin de récupérer le commentaire
     */
    public function conservePartSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $this->party->setSignals(2);
            $this->managerPart->updateSignaler($this->comment, $_POST['id']);
            self::$success = 'Récupération de la partie';
        }else{
            self::$error = 'Un problème est survenu lors de la récupération de la partie';
        }
    }

    /**
     * Méthode qui met à jours les signalements (partie) afin de supprimer le commentaire
     */
    public function deletePartSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'SuppressParty')){
                $this->managerPart->delete($_POST['id']);
                self::$success = 'Suppression de la partie';
            }else{
                self::$error = 'Un problème est survenu lors de la suppression de la partie';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * Méthode qui met à jours les signalements (JDR) afin de récupérer le commentaire
     */
    public function conservePartCOMSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $this->dialog->setSignals(2);
            $this->dialogManager->updateSignaler($this->dialog, $_POST['id']);
            self::$success = 'Récupération du commentaire';
        }else{
            self::$error = 'Un problème est survenu lors de la récupération de la partie';
        }
    }

    /**
     * Méthode qui met à jours les signalements (JDR) afin de supprimer le commentaire
     */
    public function deletePartCOMSignals()
    {
        if (isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'SuppressCOMParty')){
                $this->dialogManager->delete($_POST['id']);
                self::$success = 'Suppression du commentaire diag';
            }else{
                self::$error = 'Un problème est survenu lors de la suppression du commentaire.';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous forme de "string"
     */
    public static function messageErrorForm()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme de "string"
     */
    public static function messageSuccessForm()
    {
        return self::$success;
    }
}
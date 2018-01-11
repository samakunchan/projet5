<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 20/12/2017
 * Time: 23:34
 */

namespace Controllers;
use App\Routing\Route;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Booking;
use Models\Entity\Users;
use Models\Manager\BookingManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\UsersManager;
use Models\Entity\DialogSpace;
use Models\Manager\DialogSpaceManager;

/**
 * Class ShowController
 * @package Controllers
 * Class qui gère l'affichage d'une partie de JDR spécifique
 */
class ShowController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('show')"
     */
    private $view;

    /**
     * @var Users
     * Contient "new Users()"
     */
    private $user;

    /**
     * @var Booking
     * Contient "new Booking()"
     */
    private $booking;

    /**
     * @var BookingManager
     * Contient "new BookingManager()"
     */
    private $bookingManager;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $manager;

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
     * Contient le message d'erreur que la page n'existe pas
     */
    private static $noPage;

    /**
     * @var
     * Contient le message de success
     */
    private static $success;

    /**
     * ShowController constructor.
     * Stock "new Views('show')" dans son attribut
     * Stock "new Users()" dans son attribut
     * Stock "new Booking()" dans son attribut
     * Stock "new BookingManager()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new DialogSpace()" dans son attribut
     * Stock "new DialogSpaceManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('show');
        $this->user = new Users();
        $this->booking = new Booking();
        $this->bookingManager = new BookingManager();
        $this->userManager = new UsersManager();
        $this->manager = new PropositionPartyManager();
        $this->dialog = new DialogSpace();
        $this->dialogManager = new DialogSpaceManager();
    }

    /**
     * Méthode qui :
     * Construit la page d'affichage d'une partie de JDR spécifique
     * Si il reçoit des données de type $post, il lance la méthode adapté
     */
    public function buildShowPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                if (isset($_POST['action']) && !empty($_POST['action'])){//
                    if ($_POST['action'] === 'booking'){//
                        $this->bookParty();
                    }elseif ($_POST['action'] === 'partyComment'){//
                        $this->partyComment();
                    }elseif ($_POST['action'] === 'signal'){
                        $this->setSignals();
                    }
                }
            }
        }

        if (isset($_GET['id']) && !empty($_GET['id']) &&
            isset($_GET['title']) && !empty($_GET['title'])){
            $result = $this->manager->read($_GET['id']);
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $resultUser = $this->userManager->read($_SESSION['username']);
                $userBookedSimple = $this->bookingManager->read($resultUser->getId(), $_GET['id']);
                $allUserBooked = $this->bookingManager->readAllUserBooked($_GET['id']);
                $commentParty = $this->dialogManager->readAll($result->getId());
                $this->view->genererPages([$result, $allUserBooked, $resultUser, $userBookedSimple, $commentParty, self::messageSuccessComment()]);
            }else{
                $userBooked2 = $this->bookingManager->readAllUserBooked($_GET['id']);
                $this->view->genererPages([$result, $userBooked2, self::messageNoPage()]);
            }
        }else{
            self::$noPage = "Cette page n'existe pas";
        }
    }

    /**
     * Méthode qui gère les boutons "Rejoindre" et "Quitter"
     * @return bool
     */
    public function bookParty()
    {
        if (isset($_POST['booking']) && !empty($_POST['booking']) &&
            isset($_POST['booking_title']) && !empty($_POST['booking_title']) &&
            isset($_POST['id_author']) && !empty($_POST['id_author']) &&
            isset($_POST['mode']) && !empty($_POST['mode'])){
            if ($_POST['mode'] === 'join'){
                $this->booking->setUserId($_POST['id_author']);
                $this->booking->setBooked($_POST['booking']);
                $this->booking->setBookingTitle($_POST['booking_title']);
                $this->bookingManager->create($this->booking);
                Route::redirection('http://localhost/projet5/Public/show/'.$_POST['url'].'-'.$_POST['booking'].'');
                return true;
            }elseif ($_POST['mode'] === 'leave'){
                $partyBooked = $this->bookingManager->read($_POST['id_author'],$_GET['id']);
                $this->bookingManager->delete($partyBooked->getDates());
                Route::redirection('http://localhost/projet5/Public/show/'.$_POST['url'].'-'.$_POST['booking'].'');
                return true;
            }
        }
    }

    /**
     * Méthode qui gère la création d'un commentaire dans la partie de JDR
     */
    public function partyComment()
    {
        if (isset($_POST['author']) && !empty($_POST['author']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['party_id']) && !empty($_POST['party_id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'ProtectedCommentParty')){
                $result = $this->manager->read($_GET['id']);
                $resultUser = $this->userManager->read($_POST['author']);
                $this->dialog->setAuthor($resultUser->getFullname());
                $this->dialog->setContent($_POST['content']);
                $this->dialog->setPartyId($_POST['party_id']);
                $this->dialogManager->create($this->dialog);
                self::$success = 'Commentaire créé avec succès';
                $delai=2;
                $url='http://localhost/projet5/Public/show/'.$result->getUrl().'-'.$result->getId();
                header("Refresh: $delai;url=$url");
            }
        }
    }

    /**
     * Méthode qui gère le signalement d'un commentaire dans un partie de JDR
     */
    public function setSignals()
    {
        if (isset($_POST['diag_id']) && !empty($_POST['diag_id'])){
            $this->dialog->setSignals(1);
            $this->dialogManager->updateSignaler($this->dialog, $_POST['diag_id']);
            self::$success = 'Vous avez signalé ce commentaire. Merci de votre implication.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous forme de "string"
     */
    public static function messageNoPage()
    {
        return self::$noPage;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme de "string"
     */
    private static function messageSuccessComment()
    {
        return self::$success;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 13/12/2017
 * Time: 13:32
 */

namespace Controllers;
use App\Routing\Route;
use App\Tools\Views;
use Models\Entity\Users;
use Models\Manager\BookingManager;
use Models\Manager\CommentsManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\UsersManager;
use Models\Manager\DialogSpaceManager;

/**
 * Class MemberAreaController
 * @package Controllers
 * Class qui gère l'affichage de l'espace membre
 */
class MemberAreaController
{
    /**
     * @var Views
     * Contient "new Views('memberArea')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $managerUser;

    /**
     * @var CommentsManager
     * Contient "new CommentsManager()"
     */
    private $managerCom;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $managerPart;

    /**
     * @var BookingManager
     * Contient "new BookingManager()"
     */
    private $bookingManager;

    /**
     * @var DialogSpaceManager
     * Contient "new DialogSpaceManager()"
     */
    private $dialogManager;

    /**
     * @var Users
     * Contient "new Users()"
     */
    private $users;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $msg;

    /**
     * MemberAreaController constructor.
     * Stock "new Views('memberArea')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new CommentsManager()" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new DialogSpaceManager()" dans son attribut
     * Stock "new Users()" dans son attribut
     * Stock "new BookingManager()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('memberArea');
        $this->managerUser = new UsersManager();
        $this->managerCom = new CommentsManager();
        $this->managerPart = new PropositionPartyManager();
        $this->dialogManager = new DialogSpaceManager();
        $this->users = new Users();
        $this->bookingManager = new BookingManager();
    }

    /**
     * Méthode qui :
     * Construit la page de l'espace membre
     * Affiche des données en fonction de l'accessibilité d'un utilisateur
     * Si il reçoit des données de type $file pour le changement d'avatar, il lance la méthode "changeAvatar()"
     */
    public function buildMemberAreaPage()
    {
        if ($_FILES){
            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
                $this->changeAvatar();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && $_SESSION['username'] !==''){
                $result = $this->managerUser->read($_SESSION['username']);
                $signalsCom = $this->managerCom->readAllSignalement();
                $signalsPart = $this->managerPart->readAllSignalement();
                $signalDialog = $this->dialogManager->readAllSignalement();
                $partyBooked = $this->bookingManager->readPartyBooked($result->getId());
                $mj = $this->managerPart->readPartyCreate($result->getId());
                if ($result->getRoles()=== 'ROLE_ADMIN' ||
                    $result->getRoles()=== 'ROLE_USER' ||
                    $result->getRoles()=== 'ROLE_MODO'){
                    if (isset($_GET['id']) && !empty($_GET['id'])){
                        $this->view->genererPages(
                            [
                            $result,
                            self::messageFlash(),
                            $partyBooked,
                            $signalsCom,
                            $signalsPart,
                            $mj,
                            $signalDialog
                            ]
                        );
                    }
                }else{
                    header('HTTP/1.0 403 Forbidden');
                    die('<p class="introuvable" style="font-size: 100px;text-align: center; margin-top: 80px;">Accès interdit</p>');
                }
            }
        }else{
            Route::redirection('../register');
        }
    }

    /**
     * Méthode qui gère le changement d'avatar
     */
    public function changeAvatar()
    {
        if (isset($_POST['id']) && $_POST['id'] !==''){
            $maxOctets = 2097152;
            $validExtension = ['jpg', 'jpeg', 'gif', 'png'];
            if ($_FILES['avatar']['size'] <= $maxOctets){
                $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                if (in_array($extensionUpload, $validExtension)){
                    $wayToFiles = '../Public/src/images/avatar/'.$_POST['id'].'.'.$extensionUpload;
                    $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $wayToFiles);
                    if ($result){
                        $this->users->setAvatar($_POST['id'].'.'.$extensionUpload);
                        $this->managerUser->updateAvatar($this->users);
                    }else{
                        $msg = 'Probleme d\'importation du fichier';
                        self::$msg = $msg;
                    }// else msg d'erreur sur l'importation du fichier
                }else{
                    $msg = 'Format non reconnu';
                    self::$msg = $msg;
                } //else msg d'erreur sur le type de fichier
            }else{
                $msg = 'la taille du fichier est supérieur à 2MO';
                self::$msg = $msg;
            }// else msg d'erreur sur la taille du fichier
        }
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme "string"
     */
    public static function messageFlash()
    {
        return self::$msg;
    }

    /**
     * Méthode static qui compte le nombre de party créé par un utilisateur
     */
    public static function totalParty()
    {
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
            $userId = new UsersManager();
            $res = $userId->read($_SESSION['username']);
            $managerPart = new PropositionPartyManager();
            $total = $managerPart->getTotal($res->getId());
        }
    }

    /**
     * Méthode static qui compte le nombre de party booké par un utilisateur
     */
    public static function totalBooking()
    {
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
            $userId = new UsersManager();
            $res = $userId->read($_SESSION['username']);
            $bookingManager = new BookingManager();
            return $bookingManager->getTotal($res->getId());
        }
    }
}
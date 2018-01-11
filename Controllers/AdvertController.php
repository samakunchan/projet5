<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 13/12/2017
 * Time: 13:27
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Comments;
use Models\Manager\AdvertManager;
use Models\Manager\CommentsManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\UsersManager;

/**
 * Class AdvertController
 * @package Controllers
 * Class qui gère l'affichage de la page d'annonce
 */
class AdvertController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('advert')"
     */
    private $view;

    /**
     * @var AdvertManager
     * Contient "new AdvertManager()"
     */
    private $manager;

    /**
     * @var PropositionPartyManager
     * Contient  "new PropositionPartyManager()"
     */
    private $partyManager;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var
     * Contient le résultat des informations de l'utilisateur connecté
     * Résultat son forme de tableau
     */
    private $dataUser;

    /**
     * @var Comments
     * Contient "new Comments()"
     */
    private $comment;

    /**
     * @var CommentsManager
     * Contient "new CommentsManager()"
     */
    private $commentManager;

    /**
     * @var
     * Contient la valeur du message d'erreur
     */
    private static $error;

    /**
     * @var
     * Contient la valeur du message de succes
     */
    private static $success;

    /**
     * AdvertController constructor.
     * Stock "new Views('advert') " dans son attribut
     * Stock "new AdvertManager() " dans son attribut
     * Stock "new PropositionPartyManager() " dans son attribut
     * Stock "new UsersManager() " dans son attribut
     * Stock "new Comments() " dans son attribut
     * Stock "new CommentsManager() " dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('advert');
        $this->manager = new AdvertManager();
        $this->partyManager = new PropositionPartyManager();
        $this->userManager = new UsersManager();
        $this->comment = new Comments();
        $this->commentManager = new CommentsManager();
    }

    /**
     * Méthode qui :
     * Contruit la page d'annonce
     * Ouvre une session
     * Lis les données de l'utilisateur connecté et le stock dans son attribut
     * Reçoit les $post de "commentaire" et de "signalement" et la méthode adapté (postComment() et setSignal())
     */
    public function buildAdvertPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                if (isset($_POST['mode']) && !empty($_POST['mode'])){
                    if ($_POST['mode'] === 'commenter'){
                        $this->postComment();
                    }elseif ($_POST['mode']  === 'signaler'){
                        $this->setSignals();
                    }
                }
            }
        }
        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $this->dataUser = $this->userManager->read($_SESSION['username']);
            }
        }
            $resultArt = $this->manager->readLastOne();
            $resultCom = $this->commentManager->readAll($resultArt[0]->getId());
            $this->view->genererPages([$resultArt, $this->dataUser, $resultCom, self::messageErrorComment(), self::messageSuccessComment()]);
    }

    /**
     * Méthode qui s'occupe de créer et envoyer les commentaires dans la BDD
     */
    public function postComment()
    {
        if (isset($_POST['author']) && !empty($_POST['author']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['art_id']) && !empty($_POST['art_id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormComment')){
                $this->comment->setAuthor($_POST['author']);
                $this->comment->setContent($_POST['content']);
                $this->comment->setArtId($_POST['art_id']);
                $this->commentManager->create($this->comment);
                self::$success = 'Commentaire créé avec succès';
                $delai=2;
                $url='http://localhost/projet5/Public/advert';
                header("Refresh: $delai;url=$url");
            }else{
                self::$error = 'Un problème est survenu lors de la modification de votre commentaire';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * Méthode qui marque les commentaires signaler, en faisant évoluer la valeur "signals"
     */
    public function setSignals()
    {
        if (isset($_POST['com_id']) && !empty($_POST['com_id'])){
            $this->comment->setSignals(1);
            $this->commentManager->updateSignaler($this->comment, $_POST['com_id']);
            self::$success = 'Vous avez signalé ce commentaire. Merci de votre implication.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous de "string"
     */
    private static function messageErrorComment()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous de "string"
     */
    private static function messageSuccessComment()
    {
        return self::$success;
    }
}
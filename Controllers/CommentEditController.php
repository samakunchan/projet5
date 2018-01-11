<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 23/12/2017
 * Time: 21:51
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Comments;
use Models\Manager\CommentsManager;
use Models\Manager\UsersManager;
use App\Routing\Route;

/**
 * Class CommentEditController
 * @package Controllers
 * Class qui gère la modification et la suppression des commentaires (accessible à tous sauf utilisateur anonyme)
 */
class CommentEditController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('commentEdit')"
     */
    private $view;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var CommentsManager
     * Contient "new CommentsManager()"
     */
    private $managerCom;

    /**
     * @var Comments
     * Contient "new Comments()"
     */
    private $comment;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $error;

    /**
     * @var
     * Contient le message de sucess
     */
    private static $success;

    /**
     * CommentEditController constructor.
     * Stock "new Views('commentEdit')" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new CommentsManager()" dans son attribut
     * Stock "new Comments()" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('commentEdit');
        $this->userManager = new UsersManager();
        $this->managerCom = new CommentsManager();
        $this->comment = new Comments();
    }

    /**
     * Méthode qui :
     * Construit la page de la modification du commentaire
     * Control l'accessibilité (accessible à tous sauf utilisateur anonyme)
     * Ouvre une session
     * Si il recoit des données de type $post (modifier ou supprimer, il lance la méthode demandé (updateComment() ou deleteComment())
     */
    public function buildCommentEditPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                if (isset($_POST['mode']) && !empty($_POST['mode'])){
                    if ($_POST['mode']=== 'modifier'){
                        $this->updateComment();
                    }elseif ($_POST['mode']=== 'supprimer'){
                        $this->deleteComment();
                    }
                }
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                if ($_GET){
                    if (isset($_GET['id']) && !empty($_GET['id']) &&
                        isset($_GET['page']) && !empty($_GET['page']) ){
                        $resultAdvert = $this->managerCom->read($_GET['id']);
                        $resultUser = $this->userManager->read($_SESSION['username']);
                        if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                            $resultUser->getRoles()=== 'ROLE_MODO'||
                            $resultUser->getRoles()=== 'ROLE_USER'){
                            $this->view->genererPages([$resultUser, $resultAdvert, self::messageErrorComment(), self::messageSuccessComment()]);
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
     * Méthode qui gère la mise à jours d'un commentaire
     */
    public function updateComment()
    {
        if (isset($_POST['author']) && !empty($_POST['author']) &&
            isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormComment')){
                $this->comment->setAuthor($_POST['author']);
                $this->comment->setContent($_POST['content']);
                $this->managerCom->update($this->comment, $_POST['id']);
                self::$success = 'Vos données ont été mis à jours.';
            }else{
                self::$error = 'Un problème est survenu lors de la mise à jour de votre commentaire';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * Méthode qui gère la suppression d'un commentaire
     */
    public function deleteComment()
    {
        if (isset($_POST['id']) && !empty($_POST['id']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormCommentSupp')){
                $this->managerCom->delete($_POST['id']);
                Route::redirection('../advert');
            }
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
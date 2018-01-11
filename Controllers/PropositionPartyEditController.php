<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 28/12/2017
 * Time: 10:07
 */

namespace Controllers;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\Category;
use Models\Entity\PropositionParty;
use Models\Manager\CategoryManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\AdvertManager;
use Models\Manager\UsersManager;
use App\Routing\Route;

/**
 * Class PropositionPartyEditController
 * @package Controllers
 * Class qui gère la modification d'une partie de JDR (EXCLIVITE : AUTEUR DU JDR)
 */
class PropositionPartyEditController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('propositionPartyEdit')"
     */
    private $view;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionPartyManager()"
     */
    private $partyManager;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $category;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var PropositionParty
     * Contient "new PropositionParty()"
     */
    private $propositionParty;

    /**
     * @var array
     * Contient les données de la partie créé
     */
    private $resultParty;

    /**
     * @var mixed
     * Contient la date sous forme "int" pour la concaténation des images logo
     */
    private $date;

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
     * PropositionPartyEditController constructor.
     * Stock "new Views('propositionPartyEdit')" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new PropositionParty()" dans son attribut
     * Stock le résulata de la partie de JDR créé dans son attribut
     * Stock la date en format "int" dans son attribut
     */
    public function __construct()
    {
        $this->view = new Views('propositionPartyEdit');
        $this->partyManager = new PropositionPartyManager();
        $this->category = new CategoryManager();
        $this->userManager = new UsersManager();
        $this->propositionParty = new PropositionParty();
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $this->resultParty = $this->partyManager->read($_GET['id']);
        }
        $this->date = str_replace(':', '', date("H:i:s"));
    }

    /**
     * Méthode qui :
     * Construit la page de la modification d'une partie de JDR
     * Ouvre une session
     * Si il reçoit des données de type $post, il ouvre la méthode "publishProposition()"
     */
    public function buildPropositionPartyEditPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->modifyParty();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                if ($_GET){
                    if (isset($_GET['id']) && !empty($_GET['id']) &&
                        isset($_GET['page']) && !empty($_GET['page']) &&
                        isset($_GET['title']) && !empty($_GET['title'])){
                        $this->resultParty = $this->partyManager->read($_GET['id']);
                        $resultUser = $this->userManager->read($_SESSION['username']);
                        $cat = $this->category->readAll();
                        if ($resultUser->getRoles()=== 'ROLE_ADMIN' ||
                            $resultUser->getRoles()=== 'ROLE_MODO' ||
                            $resultUser->getRoles()=== 'ROLE_USER'){
                            $this->view->genererPages([$resultUser, $cat, $this->resultParty, self::messageErrorAdvert(), self::messageSuccessAdvert()]);
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
     * Méthode qui gère la modifiaction d'une partie de JDR
     * Permet d'envoyé un "titre"
     * Permet d'envoyé un "synopsie" (contenu)
     * Permet d'envoyé un "nombre de joueur requis"
     * Permet de choisir un catégorie
     * Permet de choisir un logo
     */
    public function modifyParty()
    {
        if (isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['categories']) && !empty($_POST['categories']) &&
            isset($_POST['nbPlayer']) && !empty($_POST['nbPlayer']) &&
            isset($_POST['id_author']) && !empty($_POST['id_author']) &&
            isset($_POST['id_party']) && !empty($_POST['id_party']) &&
            isset($_POST['name_author']) && !empty($_POST['name_author']) &&
            isset($_POST['token_csrf']) && !empty($_POST['token_csrf'])){
            if ($this->checkTokenCSRF($_POST['token_csrf'], 'protectedFormProposition')){
                $this->propositionParty->setTitle($_POST['title']);
                $this->propositionParty->setContent($_POST['content']);
                $this->propositionParty->setCatId($_POST['categories']);
                $this->propositionParty->setSpotMax($_POST['nbPlayer']);
                $this->propositionParty->setIdAuthor($_POST['id_author']);
                $this->propositionParty->setNameAuthor($_POST['name_author']);

                if (isset($_POST['id_file']) && $_POST['id_file'] !==''){
                    $maxOctets = 2097152;
                    $validExtension = ['jpg', 'jpeg', 'gif', 'png'];
                    if (isset($_FILES['images']) && !empty($_FILES['images']['name'])){
                        if ($_FILES['images']['size'] <= $maxOctets){
                            $extensionUpload = strtolower(substr(strrchr($_FILES['images']['name'], '.'), 1));
                            if (in_array($extensionUpload, $validExtension)){
                                $wayToFiles = '../Public/src/images/logos/'.$this->date.$_POST['id_file'].'.'.$extensionUpload;
                                $result = move_uploaded_file($_FILES['images']['tmp_name'], $wayToFiles);
                                if ($result){
                                    $this->propositionParty->setImages($this->date.$_POST['id_file'].'.'.$extensionUpload);
                                }else{
                                    $msg = 'Problème d\'importation du fichier';
                                    self::$error = $msg;
                                }
                            }else{
                                $msg = 'Format non reconnu';
                                self::$error = $msg;
                            }
                        }else{
                            $msg = 'la taille du fichier est supérieur à 2MO';
                            self::$error = $msg;
                        }
                    }else{
                        $this->propositionParty->setImages($this->resultParty->getImages());
                    }

                }
                $titleForUrl = str_replace(' ', '-', $_POST['title']);
                $this->propositionParty->setUrl(strtolower($titleForUrl));
                $this->partyManager->update($this->propositionParty, $_POST['id_party']);// Update
                self::$success = 'Votre annonce a été publié.';
            }else{
                self::$error = 'Un problème est survenu lors de la création de votre annonce';
            }
        }else{
            self::$error = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous forme de "string"
     */
    private static function messageErrorAdvert()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme de "string"
     */
    private static function messageSuccessAdvert()
    {
        return self::$success;
    }
}
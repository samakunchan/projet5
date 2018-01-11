<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 19/12/2017
 * Time: 17:37
 */

namespace Controllers;
use App\Routing\Route;
use App\Tools\ToolsForm;
use App\Tools\Views;
use Models\Entity\PropositionParty;
use Models\Manager\CategoryManager;
use Models\Manager\PropositionPartyManager;
use Models\Manager\UsersManager;

/**
 * Class PropositionPartyController
 * @package Controllers
 * Class qui gère la création d'une partie de JDR
 */
class PropositionPartyController extends ToolsForm
{
    /**
     * @var Views
     * Contient "new Views('propositionParty')"
     */
    private $views;

    /**
     * @var PropositionPartyManager
     * Contient "new PropositionParty()"
     */
    private $propositionManager;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $userManager;

    /**
     * @var PropositionParty
     * Contient "new PropositionPartyManager()"
     */
    private $propositionParty;

    /**
     * @var CategoryManager
     * Contient "new CategoryManager()"
     */
    private $category;

    /**
     * @var mixed
     * Contient la date sous forme "int" pour la concaténation des images logo
     */
    private $date;

    /**
     * @var
     * Contient le message d'erreur (EXCLUSIVITE: avatar)
     */
    private static $msg;

    /**
     * @var
     * Contient le message d'erreur
     */
    private static $msgError;

    /**
     * @var
     * Contient le message de succes
     */
    private static $success;

    /**
     * PropositionPartyController constructor.
     * Stock "new Views('propositionParty')" dans son attribut
     * Stock "new PropositionParty()" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     * Stock "new PropositionPartyManager()" dans son attribut
     * Stock "new CategoryManager()" dans son attribut
     * Stock la date en format "int" dans son attribut
     */
    public function __construct()
    {
        $this->views = new Views('propositionParty');
        $this->propositionParty = new PropositionParty();
        $this->userManager = new UsersManager();
        $this->propositionManager = new PropositionPartyManager();
        $this->category = new CategoryManager();
        $this->date = str_replace(':', '', date("H:i:s"));
    }

    /**
     * Méthode qui :
     * Construit la page de la création d'une partie de JDR
     * Ouvre une session
     * Si il reçoit des données de type $post, il ouvre la méthode "publishProposition()"
     */
    public function buildPropositionPartyPage()
    {
        if ($_POST){
            if (isset($_POST) && !empty($_POST)){
                $this->publishProposition();
            }
        }

        if ($_SESSION){
            if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
                $result = $this->userManager->read($_SESSION['username']);
                $cat = $this->category->readAll();
                if ($result->getRoles()=== 'ROLE_ADMIN' ||
                    $result->getRoles()=== 'ROLE_MODO' ||
                    $result->getRoles()=== 'ROLE_USER'){
                    $this->views->genererPages([$result, $cat, self::messageErrorParty(), self::messageSuccessParty()]);
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
     * Méthode qui gère la publication d'une partie de JDR
     * Permet d'envoyé un "titre"
     * Permet d'envoyé un "synopsie" (contenu)
     * Permet d'envoyé un "nombre de joueur requis"
     * Permet de choisir un catégorie
     * Permet de choisir un logo
     */
    public function publishProposition()
    {
        if (isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['categories']) && !empty($_POST['categories']) &&
            isset($_POST['nbPlayer']) && !empty($_POST['nbPlayer']) &&
            isset($_POST['id_author']) && !empty($_POST['id_author']) &&
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
                                    self::$msg = $msg;
                                }
                            }else{
                                $msg = 'Format non reconnu';
                                self::$msg = $msg;
                            }
                        }else{
                            $msg = 'la taille du fichier est supérieur à 2MO';
                            self::$msg = $msg;
                        }
                    }else{
                        $this->propositionParty->setImages('default.png');
                    }
                }
                $titleForUrl = str_replace(' ', '-', $_POST['title']);
                $this->propositionParty->setUrl(strtolower($titleForUrl));
                $this->propositionManager->create($this->propositionParty);
                self::$success = 'Votre annonce a été publié.';
            }else{
                self::$msgError = 'Un problème est survenu lors de la création de votre annonce';
            }
        }else{
            self::$msgError = 'Les champs ne doivent pas être vide.';
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous de "string" pour l'avatar
     */
    public static function messageFlash()
    {
        return self::$msg;
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur sous forme de "string"
     */
    private static function messageErrorParty()
    {
        return self::$msgError;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes sous forme de "string"
     */
    private static function messageSuccessParty()
    {
        return self::$success;
    }
}
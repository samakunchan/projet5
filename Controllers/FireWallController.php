<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 13/12/2017
 * Time: 09:34
 */

namespace Controllers;
use App\Routing\Route;
use App\Tools\ToolsForm;
use Models\Entity\Users;
use Models\Manager\UsersManager;

/**
 * Class FireWallController
 * @package Controllers
 * Class qui gère le control des données du formulaire de d'inscription,
 * de connection, de la mise à jour et de la suppression d'un utilisateur
 * Mise à jour de rôle (EXCLUSIVITE : ADMIN)
 */
class FireWallController extends ToolsForm
{
    /**
     * @var Users
     * Contient "new Users()"
     */
    private $user;

    /**
     * @var array
     * Contient les données de type $post provenant du "register" ou "admin"
     */
    private $formData;

    /**
     * @var UsersManager
     * Contient "new UsersManager()"
     */
    private $manager;

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
     * FireWallController constructor.
     * @param array $value
     * Reçoit les données depuis RegisterController et AdminController
     * Stock "new Users()" dans son attribut
     * Stock "$value" dans son attribut
     * Stock "new UsersManager()" dans son attribut
     */
    public function __construct(Array $value)
    {
        $this->user = new Users();
        $this->formData = $value;
        $this->manager= new UsersManager();
    }

    /**
     * Action provenant de "register"
     * Méthode qui distingue l'action d'inscription ou de connection d'un utilisateur
     */
    public function action()
    {
        if (isset($this->formData['token_form']) &&
            $this->formData['token_form']=== 'register'){
            $validRegister = $this->register();
        }elseif(isset($this->formData['token_form']) &&
            $this->formData['token_form']=== 'login'){
            $validLogin = $this->login();
        }
    }

    /**
     * Action provenant de "register"
     * @return bool
     * Méthode qui gère la connection d'un utilisateur à son espace membre
     * Il lis les données reçut
     * Compare la mot de passe reçut et le mot de passe stocké dans la BDD
     * Effectue une redirection vers l'espace membre si tout est bon
     */
    public function login()
    {
        if ($this->formData){
            if (isset($this->formData['username']) && $this->formData['username']!=='' &&
                isset($this->formData['password']) && $this->formData['password']!=='' &&
                isset($this->formData['token_csrf']) && $this->formData['token_csrf']!==''){
                $result = $this->manager->read($this->formData['username']);
                if ($result){
                    if ($this->formData['username'] === $result->getUsername()  && sha1($this->formData['password']) === $result->getPassword()){
                        if ($this->checkTokenCSRF($this->formData['token_csrf'], 'protectedForm')){
                            $_SESSION['username'] = $this->formData['username'];
                            $this->user->setUsername($this->formData['username']);
                            $this->user->setIsActive(true);
                            $this->manager->updateActive($this->user);
                            Route::redirection('memberArea/'.$this->formData['username']);
                        }
                    }else{
                        self::$error = 'Login ou mot de passe incorrect.';
                    }
                }else{
                    self::$error = 'Login ou mot de passe incorrect.';
                }
            }
        }else{
            self::$error = 'Veuillez remplir tout les champs. Ils ne peuvent être vide.';
        }
        return true;
    }

    /**
     * Action provenant de "login"
     * @return bool
     * Méthode qui gère l'inscription d'un utilisateur
     * Il vérifie si il existe un utilisateur avec le même username dnas la BDD.
     * Il vérifie si il existe un utilisateur avec le même email dnas la BDD.
     * Control si le mot de passe est bien identique
     * Il créé et envoie les informations de l'utilisateur dans la BDD
     */
    public function register()
    {
        if (isset($this->formData['fullname']) && $this->formData['fullname']!=='' &&
            isset($this->formData['username']) && $this->formData['username']!=='' &&
            isset($this->formData['email']) && $this->formData['email']!=='' &&
            isset($this->formData['password']) && $this->formData['password']!=='' &&
            isset($this->formData['passwordConf']) && $this->formData['passwordConf']!==''&&
            isset($this->formData['token_csrf']) && $this->formData['token_csrf']!==''){
            $userAlreadyExist = $this->manager->read($this->formData['username']);
            $emailAlreadyExist = $this->manager->readEmail($this->formData['email']);
            if ($userAlreadyExist){
                self::$error = 'Utilisateur '.$this->formData['username'].' déja éxistant.';
                return false;
            }elseif ($emailAlreadyExist){
                self::$error = 'Email '.$this->formData['email'].' déja éxistant.';
                return false;
            }
            if ($this->checkTokenCSRF($this->formData['token_csrf'], 'protectedForm')){
                if ($this->formData['password']!==$this->formData['passwordConf']){
                    self::$error = 'Erreur : Les mots de passe doivent être identique.';
                    return false;
                }else{
                    $this->user->setFullname($this->formData['fullname']);
                    $this->user->setUsername($this->formData['username']);
                    $this->user->setEmail($this->formData['email']);
                    $this->user->setRoles('ROLE_USER');
                    $this->user->setAvatar('1.png');
                    $this->user->setPassword([$this->formData['password'],$this->formData['passwordConf']]);
                    $this->manager->create($this->user);
                    self::$success = 'La création de votre espace à été effectué, vous pouvez vous connecté à votre compte';
                }
            }
        }else{
            self::$error = 'Veuillez remplir tout les champs. Ils ne peuvent être vide.';
        }
        return true;
    }

    /**
     * Action provenant de "admin"
     * Méthode qui distingue l'action de modification, de suppression et de confirmation de suppression
     */
    public function fireWallMode()
    {
        if (isset($this->formData['mode']) && $this->formData['mode']!==''){
            if ($this->formData['mode']==='modif'){
                $this->fireWallRoles();
            }elseif ($this->formData['mode']==='delete'){
                $this->fireWallDelete();
            }elseif ($this->formData['mode']==='confirm'){
                self::confirmDelete();
            }
        }
    }

    /**
     * Méthode qui gère le changement de rôle d'un utilisateur (EXCLUSIVITE : ADMIN)
     */
    public function fireWallRoles()
    {
        if (isset($this->formData['roles']) && $this->formData['roles'] !=='' &&
            isset($this->formData['token_csrf']) && $this->formData['token_csrf']!==''&&
            isset($this->formData['username']) && $this->formData['username']!==''){
            if ($this->checkTokenCSRF($this->formData['token_csrf'], 'protectedRoles')){
                $this->user->setUsername($this->formData['username']);
                $this->user->setRoles($this->formData['roles']);
                $this->manager->updateRoles($this->user);
                $delai=1;
                $url='http://localhost/projet5/Public/admin';
                header("Refresh: $delai;url=$url");
            }
        }
    }

    /**
     * Méthode qui gère la suppression d'un utilisateur (EXCLUSIVITE : ADMIN)
     */
    public function fireWallDelete()
    {
        if (isset($this->formData['token_csrf']) && $this->formData['token_csrf']!==''&&
            isset($this->formData['id']) && $this->formData['id']!==''){
            if ($this->checkTokenCSRF($this->formData['token_csrf'], 'protectedSuppression')){
                $result = $this->manager->readId($this->formData['id']);
                $this->manager->delete($result);
                self::$success = 'Les données ont été mis à jours.';
                $delai=1;
                $url='http://localhost/projet5/Public/admin';
                header("Refresh: $delai;url=$url");
            }
        }
    }

    /**
     * Méthode qui gère la suppression d'un utilisateur (EXCLUSIVITE : ADMIN)
     */
    public static function confirmDelete()
    {
        if (isset($_POST['fullname']) && !empty($_POST['fullname'] ) &&
            isset($_POST['id']) && !empty($_POST['id'] )){
            return $_POST;
        }
    }

    /**
     * @return mixed
     * Renvoie les messages d'erreur  "string"
     */
    public static function messageFlashForm()
    {
        return self::$error;
    }

    /**
     * @return mixed
     * Renvoie les messages de succes "string"
     */
    public static function messageSuccess()
    {
        return self::$success;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 18:46
 */

namespace Models\Entity;
use App\Tools\ToolsForUsers;
use Exception;

/**
 * Class Users
 * @package Models\Entity
 * Class qui gère la réprensation des utilisateurs
 */
class Users extends ToolsForUsers
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $fullname;

    /**
     * @var
     */
    private $username;

    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    private $password;

    /**
     * @var
     */
    private $dates;

    /**
     * @var
     */
    private $lastedDate;

    /**
     * @var
     */
    private $roles;

    /**
     * @var bool
     */
    private $isActive = false;

    /**
     * @var
     */
    private $avatar;

    /**
     * @return mixed
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return (string) htmlspecialchars(ucfirst($this->fullname));
    }

    /**
     * @param $fullname
     * @return $this
     * @throws Exception
     */
    public function setFullname($fullname)
    {
        $checkFullname = $this->validFullname($fullname);
        if ($checkFullname){
            $this->fullname = htmlspecialchars($fullname);
            return $this;
        }else{
            throw new Exception('Le champ "Fullname" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return (string) htmlspecialchars($this->username);
    }

    /**
     * @param $username
     * @return $this
     * @throws Exception
     */
    public function setUsername($username)
    {
        $checkUsername = $this->validUsername($username);
        if ($checkUsername){
            $this->username = htmlspecialchars($username);
            return $this;
        }else{
            throw new Exception('Le champ "Username" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return (string) $this->email;
    }

    /**
     * @param $email
     * @return $this
     * @throws Exception
     */
    public function setEmail($email)
    {
        $checkEmail = $this->validEmail($email);
        if ($checkEmail){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->email = htmlspecialchars($email);
                return $this;
            }else{
                throw new Exception('Le champ "email" est invalide');
            }
        }else{
            throw new Exception('Le champ "email" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return (string) htmlspecialchars($this->password);
    }

    /**
     * @param array $password
     * @return $this
     * @throws Exception
     */
    public function setPassword(Array $password)
    {
        $checkPassword = $this->validPassword($password);
        if ($checkPassword){
            $this->password = sha1($password[0]);
            return $this;
        }else{
            throw new Exception('Le champ "Password" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getLastedDate()
    {
        $lasteDate = date_create($this->lastedDate);
        return date_format($lasteDate, 'd/m/Y à H:i:s');
    }

    /**
     * @param mixed $lastedDate
     * @return Users
     */
    public function setLastedDate($lastedDate)
    {
        $this->lastedDate = $lastedDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDates()
    {
        $date = date_create($this->dates);
        return date_format($date, 'd/m/Y à H:i:s');
    }

    /**
     * @param mixed $dates
     * @return Users
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return (string) $this->roles;
    }

    /**
     * @param mixed $roles
     * @return Users
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     * @return Users
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return (string) $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return Users
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

}
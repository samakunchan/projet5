<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 19:45
 */

namespace Models\Manager;
use App\Tools\SimplyManager;

/**
 * Class UsersManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Users" pour les utilisateurs
 */
class UsersManager extends SimplyManager
{
    /**
     * Méthode utilisé pour créer des articles
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare($this->insertToDataBase('users','fullname' , 'username', 'password', 'email', 'roles', 'avatar'),
            [
                'fullname'=> $valeurs->getFullname(),
                'username' => $valeurs->getUsername(),
                'password' => $valeurs->getPassword(),
                'email' => $valeurs->getEmail(),
                'roles' => $valeurs->getRoles(),
                'avatar'=> $valeurs->getAvatar()
            ],
            'Models\Entity\Users', true);
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $pseudo
     * @return array
     */
    public function read($username)
    {
        $lecture = $this->prepare($this->selectFromDataBase('users', 'username'),[$username],
            'Models\Entity\Users', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $pseudo
     * @return array
     */
    public function readEmail($email)
    {
        $lecture = $this->prepare($this->selectFromDataBase('users', 'email'),[$email],
            'Models\Entity\Users', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $pseudo
     * @return array
     */
    public function readId($id)
    {
        $lecture = $this->prepare($this->selectFromDataBase('users', 'id'),[$id],
            'Models\Entity\Users', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $pseudo
     * @return array
     */
    public function readRoles($roles)
    {
        $lecture = $this->prepare('SELECT * FROM users WHERE roles=?',[$roles],
            'Models\Entity\Users', false, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @return array
     */
    public function readAll()
    {
        $lecture = $this->query($this->selectAllFromDataBase('users'), 'Models\Entity\Users');
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @return array
     */
    public function readAllUserBooked()
    {
        $lecture = $this->query('SELECT users.id, users.fullname, users.username, booking.booked, booking.booking_title 
FROM booking 
LEFT JOIN users ON booking.user_id = users.id',
            'Models\Entity\Booking');
        return $lecture;
    }

    /**
     * Méthode utilisé pour mettre à jour un commentaire
     * @param $valeurs
     */
    public function update($valeurs)
    {
        $lecture = $this->prepare('UPDATE users SET fullname= :fullname, username= :username, password= :password, email= :email
 WHERE username= :username',
            [
                'fullname'=> $valeurs->getFullname(),
                'username' => $valeurs->getUsername(),
                'password' => $valeurs->getPassword(),
                'email' => $valeurs->getEmail(),
            ],
            'Models\Entity\Users', true);
        return $lecture;
    }

    /**
     * Ceci est un update spécifique, d'où sa création sans SimplyManager
     * @param $valeurs
     */
    public function updateActive($valeurs)
    {
        $this->prepare('UPDATE users SET is_active = :is_active WHERE username= :username',
            [
                'username' => $valeurs->getUsername(),
                'is_active' => $valeurs->getisActive()
            ],
            'Models\Entity\Users', true);
    }

    /**
     * Ceci est un update spécifique, d'où sa création sans SimplyManager
     * @param $valeurs
     */
    public function updateBooking($valeurs, $id)
    {
        $this->prepare('UPDATE users SET booking = :booking WHERE id= :id',
            [
                'id' => $id,
                'booking' => $valeurs->getBooking()
            ],
            'Models\Entity\Users', true);
    }

    public function updateRoles($valeurs)
    {
        $this->prepare('UPDATE users SET roles = :roles WHERE username= :username',
            [
                'username' => $valeurs->getUsername(),
                'roles' => $valeurs->getRoles()
            ],
            'Models\Entity\Users', true);
    }

    public function updateAvatar($valeurs)
    {
        $this->prepare('UPDATE users SET avatar = :avatar WHERE id= :id',
            [
                'avatar' => $valeurs->getAvatar(),
                'id' => $_POST['id']
            ],
            'Models\Entity\Users', true);
    }

    public function delete($users)
    {
        $req = $this->connection()->prepare('DELETE FROM users WHERE id=:id');
        $req->bindValue(':id', $users->getId(), \PDO::PARAM_INT);
        return $req->execute();
   }
}
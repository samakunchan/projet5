<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 28/12/2017
 * Time: 06:06
 */

namespace Models\Manager;
use App\Tools\SrcManager;

/**
 * Class BookingManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Booking"
 */
class BookingManager extends SrcManager
{
    /**
     * @param $valeurs
     * Méthode qui gère la création d'un booking
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO booking (user_id, booked, booking_title, dates) 
                      VALUES (:user_id, :booked, :booking_title, now())',
            [
                'user_id'=> $valeurs->getUserId(),
                'booked' => $valeurs->getBooked(),
                'booking_title' => $valeurs->getBookingTitle()
            ],
            'Models\Entity\Booking', true);
    }

    /**
     * Méthode utilisé pour lire tout les bookings
     * @return array
     */
    public function read($id, $book)
    {
        $lecture = $this->prepare('SELECT * FROM booking WHERE user_id = :user_id AND booked = :booked',
            [
                'user_id'=> $id,
                'booked'=> $book
            ],
            'Models\Entity\Booking', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les bookings
     * @return array
     */
    public function readUserId($id)
    {
        $lecture = $this->prepare('SELECT * FROM booking WHERE user_id = :user_id',
            [
                'user_id'=> $id
            ],
            'Models\Entity\Booking', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les bookings en fonction du champ "booked"
     * @return array
     */
    public function readUserBooked($booked)
    {
        $lecture = $this->prepare('SELECT * FROM booking WHERE booked = :booked',
            [
                'booked'=> $booked
            ],
            'Models\Entity\Booking', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les bookings en joingnant les users en fonction de "user_id"
     * @return array
     */
    public function readAllUserBooked($id)
    {
        $lecture = $this->prepare('SELECT users.id, users.fullname, booking.booked, booking.booking_title
            FROM booking 
            LEFT JOIN users 
            ON booking.user_id = users.id WHERE booked = :booked',['booked' =>$id],
            'Models\Entity\Booking', false, true);
        return $lecture;
    }

    /**
     * @param $id
     * @return array
     * Méthode utilisé pour lire tout les bookings en fonction de "user_id"
     */
    public function readPartyBooked($id)
    {
        $lecture = $this->prepare('SELECT * FROM booking WHERE user_id = :user_id ',
            [
                'user_id'=> $id
            ],
            'Models\Entity\Booking', false, true);
        return $lecture;
    }

    /**
     * @param $id
     * @param $valeurs
     * @return array
     */
    public function updateBooking($id, $valeurs)
    {
        $lecture = $this->prepare('UPDATE booking SET booked = :booked, user_id = :user_id WHERE id= :id',
            [
                'id' => $id,
                'user_id'=> $valeurs->getUserId(),
                'booked' => $valeurs->getBooked()
            ],
            'Models\Entity\Booking', true);
        return $lecture;
    }

    /**
     * @param $dates
     * @return array
     */
    public function delete($dates)
    {
        $lecture = $this->prepare('DELETE FROM booking WHERE dates = :dates',
            [
                'dates' => $dates
            ],
            'Models\Entity\Booking', true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour avoir le nombre total des booking
     */
    public function getTotal($id)
    {
        $donnees = $this->prepare('SELECT COUNT(*) as nbBook FROM booking WHERE user_id = ?',
            [$id],
            'Models\Entity\Booking', false, true);
        return $donnees;
    }
}
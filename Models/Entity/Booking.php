<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 28/12/2017
 * Time: 06:05
 */

namespace Models\Entity;
use Exception;

/**
 * Class Booking
 * @package Models\Entity
 * Class qui gère la réprensation des parties Bookés
 */
class Booking
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $user_id;

    /**
     * @var
     */
    private $booked;

    /**
     * @var
     */
    private $booking_title;

    /**
     * @var
     */
    private $fullname;

    /**
     * @var
     */
    private $dates;

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
    public function getUserId()
    {
        return (int) $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return Booking
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBooked()
    {
        return $this->booked;
    }

    /**
     * @param mixed $booked
     * @return Booking
     */
    public function setBooked($booked)
    {
        $this->booked = $booked;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBookingTitle()
    {
        return htmlspecialchars($this->booking_title);
    }

    /**
     * @param mixed $booking_title
     * @return Booking
     */
    public function setBookingTitle($booking_title)
    {
        $this->booking_title = $booking_title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return (string) htmlspecialchars(ucfirst($this->fullname));
    }

    /**
     * @return mixed
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param $dates
     * @return $this
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }




}
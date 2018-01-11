<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 22:58
 */

namespace Models\Entity;
use App\Tools\ToolsForAdvert;
use Exception;

/**
 * Class PropositionParty
 * @package Models\Entity
 * Class qui gère la réprensation des partie de JDR
 */
class PropositionParty extends ToolsForAdvert
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $content;

    /**
     * @var
     */
    private $dates;

    /**
     * @var
     */
    private $cat_id;

    /**
     * @var
     */
    private $cat_name;

    /**
     * @var
     */
    private $nb_players;

    /**
     * @var
     */
    private $spot_max;

    /**
     * @var
     */
    private $images;

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $id_author;

    /**
     * @var
     */
    private $name_author;

    /**
     * @var
     */
    private $signals;

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
    public function getTitle()
    {
        return htmlspecialchars($this->title);
    }

    /**
     * @param $title
     * @return $this
     * @throws Exception
     */
    public function setTitle($title)
    {
        $checkTitle = $this->validTitle($title);
        if ($checkTitle){
            if (is_string($title)){
                $this->title = htmlspecialchars($title);
                return $this;
            }else{
                throw new Exception('Le champ "Titre" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "Titre" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return (string) $this->content; //TINY
    }

    /**
     * @param $content
     * @return $this
     * @throws Exception
     */
    public function setContent($content)
    {
        $checkContent = $this->validContent($content);
        if ($checkContent){
            if (is_string($content)){
                $this->content = $content;
                return $this;
            }else{
                throw new Exception('Le champ "Contenu" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "Contenu" est invalide');
        }
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
     * @return PropositionParty
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCatId()
    {
        return (int) $this->cat_id;
    }

    /**
     * @param $cat_id
     * @return $this
     * @throws Exception
     */
    public function setCatId($cat_id)
    {
        if (isset($cat_id) && !empty($cat_id)){
            if (is_numeric($cat_id)){
                $this->cat_id = $cat_id;
                return $this;
            }else{
                throw new Exception('Le champ "Cat_id" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Cat_id" est invalide');
        }

    }

    /**
     * @return mixed
     */
    public function getNbPlayers()
    {
        return (int) $this->nb_players;
    }

    /**
     * @param $nb_players
     * @return $this
     * @throws Exception
     */
    public function setNbPlayers($nb_players)
    {
        if (isset($nb_players) && !empty($nb_players)){
            if (is_numeric($nb_players)){
                $this->nb_players = $nb_players;
                return $this;
            }else{
                throw new Exception('Le champ "Nb_players" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Nb_players" est invalide');
        }

    }

    /**
     * @return mixed
     */
    public function getSpotMax()
    {
        return (int) $this->spot_max;
    }

    /**
     * @param $spot_max
     * @return $this
     * @throws Exception
     */
    public function setSpotMax($spot_max)
    {
        if (isset($spot_max) &&  !empty($spot_max)){
            if (is_numeric($spot_max)){
                $this->spot_max = $spot_max;
                return $this;
            }else{
                throw new Exception('Le champ "Spot_max" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Spot_max" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     * @return PropositionParty
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getUrl() //string ou autre
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return PropositionParty
     */
    public function setUrl($url) //string ou autre
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAuthor()
    {
        return (int) $this->id_author;
    }

    /**
     * @param $id_author
     * @return $this
     * @throws Exception
     */
    public function setIdAuthor($id_author)
    {
        if (isset($id_author) &&  !empty($id_author)){
            if (is_numeric( $id_author)){
                $this->id_author = $id_author;
                return $this;
            }else{
                throw new Exception('Le champ "Id_author" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Id_author" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getNameAuthor()
    {
        return htmlspecialchars(ucfirst($this->name_author));
    }

    /**
     * @param $name_author
     * @return $this
     * @throws Exception
     */
    public function setNameAuthor($name_author)
    {
        if (isset($name_author) && !empty($name_author)){
            if (is_string($name_author)){
                $this->name_author = htmlspecialchars($name_author);
                return $this;
            }else{
                throw new Exception('Le champ "Auteur" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "Auteur" est invalide');
        }
    }




    /**
     * @return mixed
     */
    public function getCatName()
    {
        return htmlspecialchars($this->cat_name);
    }

    /**
     * @param $cat_name
     * @return $this
     * @throws Exception
     */
    public function setCatName($cat_name)
    {
        if (is_string($cat_name) && !empty($cat_name)){
            if (is_string($cat_name)){
                $this->cat_name = $cat_name;
                return $this;
            }else{
                throw new Exception('Le champ "cat_name" n\'est pas une chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "cat_name" est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getSignals()
    {
        return (int) $this->signals;
    }

    /**
     * @param $signals
     * @return $this
     * @throws Exception
     */
    public function setSignals($signals)
    {
        if (isset($signals) && !empty($signals)){
            if (is_numeric($signals)){
                $this->signals = $signals;
                return $this;
            }else{
                throw new Exception('Le champ "Signal" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Signal" est invalide');
        }
    }



}
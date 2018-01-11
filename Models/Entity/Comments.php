<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 21:11
 */

namespace Models\Entity;
use App\Tools\ToolsFormComments;
use Exception;

/**
 * Class Comments
 * @package Models\Entity
 * Class qui gère la réprensation des commentaires
 */
class Comments extends ToolsFormComments
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $author;

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
    private $art_id;

    /**
     * @var
     */
    private $signals;

    /**
     * @var
     */
    private $nb_com;

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
    public function getAuthor()
    {
        return (string) htmlspecialchars($this->author);
    }

    /**
     * @param $author
     * @return $this
     * @throws Exception
     */
    public function setAuthor($author)
    {
        $checkAuthor = $this->validAuthor($author);
        if ($checkAuthor){
            if (is_string($author)){
                $this->author = htmlspecialchars($author);
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
    public function getContent()
    {
        return (string) $this->content;
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
     * @return Comments
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArtId()
    {
        return  $this->art_id;
    }

    /**
     * @param $art_id
     * @return $this
     * @throws Exception
     */
    public function setArtId($art_id)
    {
        if (isset($art_id) && !empty($art_id)){
            if (is_numeric($art_id)){
                $this->art_id = $art_id;
                return $this;
            }else{
                throw new Exception('Le champ "Art_id" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Art_id" est invalide');
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

    /**
     * @return mixed
     */
    public function getNbCom()
    {
        return (int) $this->nb_com;
    }

    /**
     * @param $nb_com
     * @return $this
     * @throws Exception
     */
    public function setNbCom($nb_com)
    {
        if (isset($nb_com) && !empty($nb_com)){
            if (is_int($nb_com)){
                $this->nb_com = $nb_com;
                return $this;
            }else{
                throw new Exception('Le champ "Nb_com" n\'est pas un entier');
            }
        }else{
            throw new Exception('Le champ "Nb_com" est invalide');
        }
    }


}
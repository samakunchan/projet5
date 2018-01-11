<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 21:10
 */

namespace Models\Entity;
use App\Tools\ToolsForAdvert;
use Exception;

/**
 * Class Adverts
 * @package Models\Entity
 * Class qui gère la réprensation des annonces
 */
class Adverts extends ToolsForAdvert
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
    private $url;

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
        return $this->content;
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
     * @return Adverts
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return (string) $this->url;
    }

    /**
     * @param $url
     * @return $this
     * @throws Exception
     */
    public function setUrl($url)
    {
        if (isset($url) && !empty($url)){
            if (is_string($url)){
                $this->url = $url;
                return $this;
            }else{
                throw new Exception('Le champ "Url" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "Url" est invalide');
        }
    }
}
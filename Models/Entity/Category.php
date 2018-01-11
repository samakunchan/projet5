<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 21:11
 */

namespace Models\Entity;
use Exception;

/**
 * Class Category
 * @package Models\Entity
 * Class qui gère la réprensation des catégories
 */
class Category
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $cat_name;

    /**
     * @var
     */
    private $description;

    /**
     * @var
     */
    private $urlCat;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
        if (isset($cat_name) && !empty($cat_name)){
            if (is_string($cat_name)){
                $this->cat_name = $cat_name;
                return $this;
            }else{
                throw new Exception('Le champ "cat_name" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "cat_name" de Category est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     * @throws Exception
     */
    public function setDescription($description)
    {
        if (isset($description) && !empty($description)){
            if (is_string($description)){
                $this->description = $description;
                return $this;
            }else{
                throw new Exception('Le champ "Description" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "Description" de Category est invalide');
        }
    }

    /**
     * @return mixed
     */
    public function getUrlCat()
    {
        return (string) $this->urlCat;
    }

    /**
     * @param $urlCat
     * @return $this
     * @throws Exception
     */
    public function setUrlCat($urlCat)
    {
        if (isset($urlCat) && !empty($urlCat)){
            if (is_string($urlCat)){
                $this->urlCat = $urlCat;
                return $this;
            }else{
                throw new Exception('Le champ "urlCat" n\'est pas un chaine de caractère');
            }
        }else{
            throw new Exception('Le champ "urlCat" de Category est invalide');
        }
    }


}
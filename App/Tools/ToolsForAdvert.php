<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 23:04
 */

namespace App\Tools;

/**
 * Class ToolsForAdvert
 * @package App\Tools
 * Class qui gère la vérification des données reçut par l'Entité "Advert"
 */
class ToolsForAdvert
{
    /**
     * Test la validité du titre
     * @param $title
     * @return bool
     */
    public function validTitle($title)
    {
        if (isset($title) && !empty($title)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Test la validité du contenu
     * @param $content
     * @return bool
     */
    public function validContent($content)
    {
        if (isset($content) && !empty($content)){
            return true;
        }else{
            return false;
        }
    }
}
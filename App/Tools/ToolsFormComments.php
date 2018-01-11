<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 23:05
 */

namespace App\Tools;

/**
 * Class ToolsFormComments
 * @package App\Tools
 * Class qui controle la validité des données de l'Entité "Comments"
 */
class ToolsFormComments
{
    /**
     * Vérifie la validité de la valeur $author
     * @param $author
     * @return bool
     */
    public function validAuthor($author)
    {
        if (isset($author) && !empty($author)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Vérifie la validité de la valeur $author
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
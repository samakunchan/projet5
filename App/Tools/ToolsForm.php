<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 12/12/2017
 * Time: 10:03
 */

namespace App\Tools;

/**
 * Class ToolsForm
 * @package App\Tools
 * Class qui simplifie l'écriture de certaines balise HTML
 * Class qui génère un token contre la faille CSRF
 */
class ToolsForm
{
    /**
     * Méthode static pour simplifié l'écriture des balises <input> et <label>
     * @param array $attr
     * @param bool $value
     * @param bool $value2
     */
    public static function input(array $attr, $value = false, $value2 = false)
    {
        echo '<div><p><label for="'.$attr['name'].'">'.ucfirst($value).'</label></p>
        <input type="'.$attr['type'].'" name="'.$attr['name'].'" id="'.$attr['name'].'" maxlength="'.$attr['lenght'].'" value="'.$value2.'" ></div>';
    }

    /**
     * Méthode static pour simplifié l'écriture des balises <input> de type "hidden"
     * @param bool $value1
     * @param bool $value2
     */
    public static function token($value1 = false, $value2 = false)
    {
        echo '<input type="hidden" name="'.$value1.'" value="'.$value2.'">';
    }

    /**
     * Méthode static pour simplifié l'écriture des balises <input> de type "submit"
     * @param $value
     * @param bool $class
     */
    public static function submit($value, $class = false)
    {
        echo '<input type="submit"  value="'.$value.'" id="'.$class.'"">';
    }

    /**
     * Méthode static pour simplifié l'écriture des balises <textarea>
     * @param bool $value1
     * @param bool $value2
     */
    public static function textArea($value1 = false, $value2 = false)
    {
        echo '<div><p><label for="'.$value1.'">'.ucfirst($value1).'</label></p>
        <textarea type="hidden" name="'.$value1.'" id="'.$value2.'"></textarea>';
    }

    /**
     * Méthode static pour généré un code crypter afin de contrer la faille CSRF
     * @param $formName
     * @return string
     */
    public static function tokenCSRF($formName)
    {
        $secretKey = 'gsfhs154aergz2#';
        if (!session_id()) {
            session_start();
        }
        //var_dump(session_id());
        $sessionId = session_id();

        return sha1($formName . $sessionId . $secretKey);
    }

    /**
     * Méthode pour vérifier le code crypter par tokenCSRF est le même recut par $post
     * @param $token
     * @param $formName
     * @return bool
     */
    public function checkTokenCSRF($token, $formName)
    {
        return $token === self::tokenCSRF($formName);
    }

}
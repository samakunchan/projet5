<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 17:49
 */

namespace App\Autoloading;

/**
 * Class Autoloader
 * @package App\Autoloading
 * Class Autoloader qui charge toute les class du projet
 */
class Autoloader{

    /**
     * Enregistre notre autoloader
     */
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    public static function autoload($class){
        $class = str_replace(__NAMESPACE__.'\\','',$class );
        $class = str_replace('\\','/',$class );
        require '../'. $class .'.php';
    }

}
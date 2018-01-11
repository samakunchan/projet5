<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 19:17
 */

namespace App\Tools;

/**
 * Class ToolsForUsers
 * @package App\Tools
 * Class qui control la validité des données reçut par l'Entité "Users"
 */
class ToolsForUsers
{
    /**
     * Vérifie la validité de la valeur de l'email reçut
     * @param $email
     * @return bool
     */
    public function validEmail($email)
    {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex)
        {
            $isValid = false;
        }
        else
        {
            $domain = substr($email, $atIndex+1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64)
            {
                // local part length exceeded
                $isValid = false;
            }
            else if ($domainLen < 1 || $domainLen > 255)
            {
                // domain part length exceeded
                $isValid = false;
            }
            else if ($local[0] == '.' || $local[$localLen-1] == '.')
            {
                // local part starts or ends with '.'
                $isValid = false;
            }
            else if (preg_match('/\\.\\./', $local))
            {
                // local part has two consecutive dots
                $isValid = false;
            }
            else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
            {
                // character not valid in domain part
                $isValid = false;
            }
            else if (preg_match('/\\.\\./', $domain))
            {
                // domain part has two consecutive dots
                $isValid = false;
            }
            else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
            {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
                {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
            {
                // domain not found in DNS
                $isValid = false;
            }
        }
        return $isValid;
    }

    /**
     * Vérifie la validité de la valeur de l'username
     * @param $username
     * @return bool
     */
    public function validUsername($username)
    {
        if (isset($username) && !empty($username)){
            if (!is_string($username)){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    /**
     * Vérifie la validité de la valeur de fullname
     * @param $fullname
     * @return bool
     */
    public function validFullname($fullname)
    {
        if (isset($fullname) && !empty($fullname)){
            if (!is_string($fullname)){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    /**
     * Vérifie la validité de la valeur du password
     * "$password" recoit un tableau. En [0], on a $post['password'], et en [1] on a $post['passwordConf']
     * @param $password
     * @return bool
     */
    public function validPassword($password)
    {
        if (isset($password) && $password !==''){
            if ($password[0] !== $password[1]){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
}
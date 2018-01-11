<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 18:24
 */

namespace App\DataBase;
use PDO;
use Exception;

/**
 * Class DataBase
 * @package App\DataBase
 * Class qui gère la connection à la BDD
 */
class DataBase
{
    private $pdo;
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;

    /**
     * Utilisation d'un contructeur par convenance
     * Facilite la modification de la base de donnée
     */
    public function __construct()
    {
        $this->db_host = 'localhost';
        $this->db_name = 'mabdd';
        $this->db_user = 'root';
        $this->db_pass= '';
    }

    /**
     * Méthode qui génère la connection de la base de donnée
     */
    public function connection()
    {
        if($this->pdo === null){
            try{
                $bdd = new PDO(
                    'mysql:host='.$this->db_host.';
                     dbname='.$this->db_name.'',
                    ''.$this->db_user.'',
                    ''.$this->db_pass.'');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $this->pdo = $bdd;
            }catch (Exception $e){
                die('Erreur : ' .$e->getMessage());
            }
        }
        return $this->pdo;
    }
}
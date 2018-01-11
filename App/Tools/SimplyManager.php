<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 11/12/2017
 * Time: 19:41
 */

namespace App\Tools;

/**
 * Class SimplyManager
 * @package App\Tools
 * Class simplifie l'écriture du CRUD
 */
class SimplyManager extends SrcManager
{
    /**
     * Méthode générique "Create"
     * @return array
     */
    public function insertToDataBase($table, $value1, $value2 = false, $value3 = false , $value4 = false, $value5 = false, $value6 = false)
    {
        $statement = '
        INSERT INTO '.$table.'
        (
        '.$value1.', 
        '.$value2.', 
        '.$value3.', 
        '.$value4.', 
        '.$value5.', 
        '.$value6.', 
        dates) 
        VALUES ( 
        :'.$value1.', 
        :'.$value2.', 
        :'.$value3.', 
        :'.$value4.', 
        :'.$value5.',
        :'.$value6.',
         now() )';
        return $statement;
    }

    /**
     * Méthode générique "Select"
     * @return array
     */
    public function selectFromDataBase($table, $value1 )
    {
        $statement = '
        SELECT * 
        FROM '.$table.' 
        WHERE '.$value1.'
        =?';
        return $statement;
    }

    /**
     * Méthode générique "Select * "
     * @return array
     */
    public function selectAllFromDataBase($table)
    {
        $statement = '
        SELECT * 
        FROM '.$table.' 
        ORDER BY id 
        DESC';
        return $statement;
    }

    /**
     * Méthode générique "Update"
     * @return array
     */
    public function updateDataForDataBase($table, $value1, $value2 = false, $value3 = false, $value4 = false)
    {
        $statement = 'UPDATE '.$table.' SET 
        '.$value1.' = :'.$value1.',
        '.$value2.' = :'.$value2.', 
        '.$value3.' = :'.$value3.', 
        '.$value4.' = :'.$value4.', 
        lastedDate = now() WHERE '.$value2.' = :'.$value2.'';
        return $statement;
    }

    /**
     * Méthode générique "Delete"
     * @return array
     */
    public function deleteDataForDataBase($table, $value)
    {
        var_dump($value);
        $statement = '
        DELETE 
        FROM '.$table.' 
        WHERE '.$value.' =:id';
        return $statement;
    }
}
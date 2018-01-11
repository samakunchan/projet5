<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 23:01
 */

namespace Models\Manager;
use App\Tools\SrcManager;

/**
 * Class CategoryManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Category" pour les catégories
 */
class CategoryManager extends SrcManager
{

    /**
     * Méthode utilisé pour créer des catégories
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO categories(cat_name, description, urlCat) 
        VALUES (:cat_name,:description, :urlCat )',
            [
                'cat_name' => $valeurs->getCatName(),
                'description' => $valeurs->getDescription(),
                'urlCat'=> $valeurs->getUrlCat()
            ],
            'Models\Entity\Category', true);
    }

    /**
     * Méthode utilisé pour lire un seul article
     * @param $id
     * @return array
     */
    public function read($id)
    {
        $lecture = $this->prepare('SELECT * FROM categories WHERE id=?',[$id],
            'Models\Entity\Category', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les catégories
     * @return array
     */
    public function readAll()
    {
        $lecture = $this->query('SELECT * FROM categories', 'Models\Entity\Category');
        return $lecture;
    }

    /**
     * Méthode utilisé pour mettre à jour un article
     * @param $valeurs
     */
    public function update($valeurs)
    {
        $this->prepare('UPDATE categories SET cat_name = :cat_name, description = :description, 
urlCat= :urlCat WHERE id= :id',
            [
                'id' => $_GET['id'], //peut etre a changer de technique en prenant les $Post
                'cat_name' => $valeurs->getCatName(),
                'description' => $valeurs->getDescription(),
                'urlCat'=> $valeurs->getUrlCat()
            ],
            'Models\Entity\Category', true);
    }
}
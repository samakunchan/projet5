<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 23:00
 */

namespace Models\Manager;
use App\Tools\SrcManager;

/**
 * Class AdvertManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Advert" pour les annonces
 */
class AdvertManager extends SrcManager
{
    /**
     * Méthode utilisé pour créer des articles
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO adverts(title, content, url, dates) 
        VALUES (:title,:content, :url, now() )',
            [
                'title' => $valeurs->getTitle(),
                'content' => $valeurs->getContent(),
                'url' => $valeurs->getUrl()
            ],
            'Models\Entity\Adverts', true);
    }

    /**
     * Méthode utilisé pour lire un seul article
     * @param $id
     * @return array
     */
    public function read($id)
    {
        $lecture = $this->prepare('SELECT * FROM adverts WHERE id=?',[$id],
            'Models\Entity\Adverts', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire le dernier article (pour l'extrait de la page d'acceuil)
     * @return array
     */
    public function readLastOne()
    {
        $lecture =$this->query('SELECT * FROM adverts ORDER BY id DESC LIMIT 1',
            'Models\Entity\Adverts');
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout articles 8 par 8 avec un système de pagination
     * Paramètre ci-dessous pour la pagination
     * @param $pageActuel
     * @param $articlesParPages
     * @return array
     */
    public function readAll($pageActuel = false ,$articlesParPages= false)
    {
        if ($pageActuel && $articlesParPages){
            $lecture = $this->query('SELECT * FROM adverts ORDER BY id DESC LIMIT '.
                (($pageActuel-1)*$articlesParPages).','.$articlesParPages.' ', 'Models\Entity\Adverts');
            return $lecture;
        }else{
            $lecture = $this->query('SELECT * FROM adverts ORDER BY id DESC ', 'Models\Entity\Adverts');
            return $lecture;
        }
    }

    /**
     * Méthode utilisé pour mettre à jour un article
     * @param $valeurs
     */
    public function update($valeurs)
    {
        $this->prepare('UPDATE adverts SET title = :title, content = :content, url= :url, 
        dates = now() WHERE id= :id',
            [
                'id' => $_GET['id'], //peut etre a changer de technique en prenant les $Post
                'title' => $valeurs->getTitle(),
                'content' => $valeurs->getContent(),
                'url' => $valeurs->getUrl()
            ],
            'Models\Entity\Adverts', true);
    }

    /**
     * Méthode utilisé pour supprimer un article
     * @param $id
     */
    public function delete($id)
    {
        $this->prepare('DELETE FROM adverts WHERE id = :id',
            [
                'id' => $id
            ],
            'Models\Entity\Adverts', true);
    }

    /**
     * Méthode utilisé pour avoir le nombre total des articles
     */
    public function getTotal()
    {
        $donnees = $this->query('SELECT COUNT(*) as nbArt FROM adverts','Models\Entity\Adverts');
        return $donnees;
    }

}
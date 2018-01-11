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
 * Class CommentsManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Comments" pour les commentaires
 */
class CommentsManager extends SrcManager
{
    /**
     * Méthode utilisé pour créer des articles
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO comments(author ,content ,art_id  ,dates ) 
        VALUES (:author, :content, :art_id, now())',
            [
                'author' => $valeurs->getAuthor(),
                'content' => $valeurs->getContent(),
                'art_id'=> $valeurs->getArtId()
            ],
            'Models\Entity\Comments', true);
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $id
     * @return array
     */
    public function readRefArticle($id)
    {
        $lecture = $this->prepare('SELECT * FROM comments WHERE art_id=?',[$id],
            'Models\Entity\Comments', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire l'article du commentaire
     * @param $id
     * @return array
     */
    public function read($id)
    {
        $lecture = $this->prepare('SELECT * FROM comments WHERE id=?',[$id],
            'Models\Entity\Comments', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @param $id
     * @return array
     */
    public function readAll($id=false)
    {
        $lecture = $this->prepare('SELECT * FROM comments WHERE art_id=?',[$id],
            'Models\Entity\Comments', false, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les signalements de commentaire
     * @return array
     */
    public function readAllSignalement()
    {
        $lecture = $this->query('SELECT * FROM comments WHERE signals=1 ORDER BY id DESC ',
            'Models\Entity\Comments');
        return $lecture;
    }

    /**
     * Méthode utilisé pour mettre à jour un commentaire
     * @param $valeurs
     */
    public function update($valeurs, $id)
    {
        $this->prepare('UPDATE comments SET author = :author ,content = :content, 
        dates = now() WHERE id= :id',
            [
                'id' => $id,
                'author' => $valeurs->getAuthor(),
                'content' => $valeurs->getContent()
            ],
            'Models\Entity\Comments', true);
    }

    /**
     * Méthode utilisé pour supprimer un commentaire
     * @param $id
     */
    public function delete($id)
    {
        $this->prepare('DELETE FROM comments WHERE id = :id',
            [
                'id' => $id
            ],
            'Models\Entity\Comments', true);
    }

    /**
     * Méthode utilisé pour mettre à jour le marqueur du signalement (0 ou 1)
     * @param $valeurs
     */
    public function updateSignaler($valeurs, $id)
    {
        $this->prepare('UPDATE comments SET signals = :signals WHERE id= :id',
            [
                'id' => $id,
                'signals' => $valeurs->getSignals()
            ],
            'Models\Entity\Comments', true);
    }

    /**
     * Méthode utilisé pour mettre à jour un article
     */
    public function getTotalSigalement() // Pas sure que j'utilise ça
    {
        $donnees = $this->query('SELECT COUNT(signals) as nbCom FROM comments WHERE signaler=1',
            'Models\Entity\Comments');
        return $donnees;
    }
}
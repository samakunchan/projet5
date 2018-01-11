<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 04/01/2018
 * Time: 19:19
 */

namespace Models\Manager;
use App\Tools\SrcManager;

/**
 * Class DialogSpaceManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "Dialog" pour les dialogues
 */
class DialogSpaceManager extends SrcManager
{
    /**
     * Méthode utilisé pour créer des articles
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO dialog(author ,content ,party_id ,dates ) 
        VALUES (:author, :content, :party_id, now())',
            [
                'author' => $valeurs->getAuthor(),
                'content' => $valeurs->getContent(),
                'party_id'=> $valeurs->getPartyId()
            ],
            'Models\Entity\DialogSpace', true);
    }

    /**
     * Méthode utilisé pour lire la référence de l'article du commentaire
     * @param $id
     * @return array
     */
    public function readRefArticle($id)// pas sure d'utiliser ça
    {
        $lecture = $this->prepare('SELECT * FROM dialog WHERE party_id=?',[$id],
            'Models\Entity\DialogSpace', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire l'article du commentaire
     * @param $id
     * @return array
     */
    public function read($id)
    {
        $lecture = $this->prepare('SELECT * FROM dialog WHERE id=?',[$id],
            'Models\Entity\DialogSpace', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @param $id
     * @return array
     */
    public function readAll($id=false)
    {
        $lecture = $this->prepare('SELECT * FROM dialog WHERE party_id=?',[$id],
            'Models\Entity\DialogSpace', false, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les signalements de commentaire
     * @return array
     */
    public function readAllSignalement()
    {
        $lecture = $this->query('SELECT * FROM dialog WHERE signals=1 ORDER BY id DESC ',
            'Models\Entity\DialogSpace');
        return $lecture;
    }

    /**
     * Méthode utilisé pour mettre à jour un commentaire
     * @param $valeurs
     */
    public function update($valeurs, $id)
    {
        $this->prepare('UPDATE dialog SET author = :author ,content = :content, 
        dates = now() WHERE id= :id',
            [
                'id' => $id,
                'author' => $valeurs->getAuthor(),
                'content' => $valeurs->getContent()
            ],
            'Models\Entity\DialogSpace', true);
    }

    /**
     * Méthode utilisé pour supprimer un commentaire
     * @param $id
     */
    public function delete($id)
    {
        $this->prepare('DELETE FROM dialog WHERE id = :id',
            [
                'id' => $id
            ],
            'Models\Entity\DialogSpace', true);
    }

    /**
     * Méthode utilisé pour mettre à jour le marqueur du signalement (0 ou 1)
     * @param $valeurs
     */
    public function updateSignaler($valeurs, $id)
    {
        $this->prepare('UPDATE dialog SET signals = :signals WHERE id= :id',
            [
                'id' => $id,
                'signals' => $valeurs->getSignals()
            ],
            'Models\Entity\DialogSpace', true);
    }

    /**
     * Méthode utilisé pour mettre à jour un article
     */
    public function getTotalSigalement() // Pas sure que j'utilise ça
    {
        $donnees = $this->query('SELECT COUNT(signals) as nbCom FROM dialog WHERE signals=1',
            'Models\Entity\DialogSpace');
        return $donnees;
    }
}
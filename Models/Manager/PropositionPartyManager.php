<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 18/12/2017
 * Time: 23:02
 */

namespace Models\Manager;
use App\Tools\SrcManager;

/**
 * Class PropositionPartyManager
 * @package Models\Manager
 * Class de création du CRUD pour l'Entity "PropositionParty" pour les parties de JDR
 */
class PropositionPartyManager extends SrcManager
{
    /**
     * Méthode utilisé pour créer des articles
     * @param $valeurs
     */
    public function create($valeurs)
    {
        $this->prepare('INSERT INTO proposition_party(title, content, cat_id, spot_max, images, url, id_author, name_author, dates) 
        VALUES (:title, :content, :cat_id, :spot_max, :images, :url, :id_author, :name_author, now() )',
            [
                'title' => $valeurs->getTitle(),
                'content' => $valeurs->getContent(),
                'cat_id' => $valeurs->getCatId(),
                'spot_max' => $valeurs->getSpotMax(),
                'images' => $valeurs->getImages(),
                'url' => $valeurs->getUrl(),
                'id_author' => $valeurs->getIdAuthor(),
                'name_author' =>$valeurs->getNameAuthor()
            ],
            'Models\Entity\PropositionParty', true);
    }

    /**
     * Méthode utilisé pour lire un seul article
     * @param $id
     * @return array
     */
    public function read($id)
    {
        $lecture = $this->prepare('SELECT * FROM proposition_party WHERE id=?',[$id],
            'Models\Entity\PropositionParty', true, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire un seul article
     * @param $id
     * @return array
     */
    public function readPartyCreate($id)
    {
        $lecture = $this->prepare('SELECT * FROM proposition_party WHERE id_author=:id_author',
            ['id_author' =>$id],
            'Models\Entity\PropositionParty', false, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire le dernier article (pour l'extrait de la page d'acceuil)
     * @return array
     */
    public function readLastOne()//A changer aussi peut etre
    {
        $lecture =$this->query('SELECT * FROM proposition_party ORDER BY id DESC LIMIT 1',
            'Models\Entity\PropositionParty');
        return $lecture;
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @return array
     */
    public function readAll($actualPage = false, $articlePerPage = false)
    {
        if ($actualPage && $articlePerPage){
            $lecture = $this->query('SELECT proposition_party.id, proposition_party.title, proposition_party.content, proposition_party.url,
proposition_party.signals, proposition_party.images, categories.cat_name
    FROM proposition_party
    LEFT JOIN categories ON proposition_party.cat_id = categories.id ORDER BY proposition_party.id DESC LIMIT '.(($actualPage-1)*$articlePerPage).','.$articlePerPage.'
', 'Models\Entity\PropositionParty');
            return $lecture;
        }else{
            $lecture = $this->query('SELECT proposition_party.id, proposition_party.title, proposition_party.content, proposition_party.url,
proposition_party.signals, proposition_party.images, categories.cat_name
    FROM proposition_party
    LEFT JOIN categories ON proposition_party.cat_id = categories.id ORDER BY proposition_party.id DESC
', 'Models\Entity\PropositionParty');
            return $lecture;
        }
    }

    /**
     * Méthode utilisé pour lire tout les commentaires
     * @return array
     */

    public function readAllSpeCaT($id)
    {
        $lecture = $this->prepare('SELECT * FROM proposition_party WHERE cat_id=? ',[$id],
            'Models\Entity\PropositionParty', false, true);
        return $lecture;
    }

    /**
     * Méthode utilisé pour mettre à jour un article
     * @param $valeurs
     */
    public function update($valeurs, $id)//title, content, cat_id, spot_max, images, url, id_author, name_author, dates
    {
        $this->prepare('UPDATE proposition_party SET title = :title, content = :content, cat_id =:cat_id, spot_max =:spot_max,
        images = :images, url =:url, id_author = :id_author, name_author =:name_author, dates = now() WHERE id= :id',
            [
                'id' => $id,
                'title' => $valeurs->getTitle(),
                'content' => $valeurs->getContent(),
                'cat_id' => $valeurs->getCatId(),
                'spot_max' => $valeurs->getSpotMax(),
                'images' => $valeurs->getImages(),
                'url' => $valeurs->getUrl(),
                'id_author' => $valeurs->getIdAuthor(),
                'name_author' =>$valeurs->getNameAuthor()
            ],
            'Models\Entity\PropositionParty', true);
    }

    /**
     * Méthode utilisé pour supprimer un article
     * @param $id
     */
    public function delete($id)
    {
        $this->prepare('DELETE FROM proposition_party WHERE id = :id',
            [
                'id' => $id
            ],
            'Models\Entity\PropositionParty', true);
    }

    /**
     * Méthode utilisé pour avoir le nombre total des parties créés
     */
    public function getTotal($id)
    {
        $donnees = $this->prepare('SELECT COUNT(*) as nbPart FROM proposition_party WHERE id_author = ?',
            [$id],
            'Models\Entity\PropositionParty', false, true);
        return $donnees;
    }

    /**
     * Méthode utilisé pour mettre à jour le marqueur du signalement (0 ou 1)
     * @param $valeurs
     */
    public function updateSignaler($valeurs, $id)
    {
        $this->prepare('UPDATE proposition_party SET signals = :signals WHERE id= :id',
            [
                'id' => $id,
                'signals' => $valeurs->getSignals()
            ],
            'Models\Entity\PropositionParty', true);
    }

    /**
     * Méthode utilisé pour lire tout les signalements de commentaire
     * @return array
     */
    public function readAllSignalement()
    {
        $lecture = $this->query('SELECT * FROM proposition_party WHERE signals=1 ORDER BY id DESC ',
            'Models\Entity\PropositionParty');
        return $lecture;
    }

}
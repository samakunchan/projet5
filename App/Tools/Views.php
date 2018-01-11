<?php
/**
 * Created by PhpStorm.
 * User: Samakunchan
 * Date: 12/12/2017
 * Time: 10:52
 */

namespace App\Tools;

/**
 * Class Views
 * @package App\Tools
 * Class qui gère la création de de la vue, en associant la page demandé et le template
 */
class Views
{
    private $fichier;
    private $gabarit;

    /**
     * Constructeur qui instancie le chemin de chaque page
     * Constructeur qui instancie le chemin du gabarit
     * @param $page
     */
    public function __construct($page)
    {
        $this->fichier = '../Views/'. $page .'.php';
        $this->gabarit = '../Views/Templates/layout.php';
    }

    /**
     * Méthode qui génère la page
     * Données est false par défaut si on ne reçoit pas de tableau de données
     * @param bool $donnees
     * @return bool
     */
    public function genererPages($donnees = false)
    {
        if ($donnees){
            if (file_exists($this->fichier)){
                ob_start();
                extract($donnees);
                require $this->fichier;
                $contenu = ob_get_clean();
                require $this->gabarit;
                return true;
            }else{
                echo 'Fichier ' . $this->fichier . ' introuvable';
            }
        }else{
            ob_start();
            require $this->fichier;
            $donnees= '';
            $contenu = ob_get_clean();
            require $this->gabarit;
            return true;
        }
    }

}
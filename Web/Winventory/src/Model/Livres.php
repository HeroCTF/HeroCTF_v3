<?php
class Livres{
    private $id;
    private $titre;
    private $prix;
    private $auteur;
    private $hasBeenRead;
    private $currentPage;
    private $associateUser;
    private $associateHouse;
    private $maxPage;

    public function __construct(){}


    public function init($titre,$prix,$auteur,$hbr,$cp,$mp){
        $this->associateUser = 0;
        $this->associateHouse = 0;
        $this->id = 0;
        $this->titre = $titre;
        $this->prix = $prix;
        $this->auteur = $auteur;
        $this->hasBeenRead = $hbr;
        $this->currentPage = $cp;
        $this->maxPage = $mp;
    }

    public function getTitre(){ return $this->titre; }
                    
    public function getPrix(){ return $this->prix; }

    public function getAuteur(){ return $this->auteur; }

    public function getHbr(){ return $this->hasBeenRead;}

    public function getCp(){ return $this->currentPage;}

    public function getId(){ return $this->id; }

    public function getCurrentHouse(){ return $this->associateHouse; }

    public function getCurrentUser(){ return $this->associateUser; }

    public function getCurrentPage(){ return $this->currentPage; }

    public function getMaxPage(){ return $this->maxPage; }
}
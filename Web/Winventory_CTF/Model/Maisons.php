<?php
class Maisons{
    private $id;
    private $nom;
    private $associateUser;

    public function __construct(){}


    public function init($nom){
        $this->id = 0;
        $this->nom = $nom;
    }

    public function getName(){ return $this->nom; }
    
    public function getId(){return $this->id; }
}
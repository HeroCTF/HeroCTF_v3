<?php
class User{
    public $pseudo;
    private $email;
    private $password;
    private $salt;

    /**
     * User constructor.of User
     */
    public function __construct(){}

    /**
     * @param $name string nom de l'abonné
     * @param $mail string mail de l'abonné
     * @param $password string mot de passe de l'abonné
     * @param $sexe string le sexe de l'abonné
     * @param $ville string la ville de la sentinelle
     * Cette fonction permet de créer un User pour ensuite l'insérer / actualiser ses données dans la base.
     */
    public function init($pseudo,$mail,$password){
        $this->pseudo = $pseudo;
        $this->email = $mail;
        $this->salt = self::generateSalt();
        $this->password = self::getSecuredPassword($password);
    }

    /**
     * @return mixed Return le nom du User
     */
    public function getPseudo(){ return $this->pseudo; }
                    
    /**
     * @return mixed Return l'email du User
     */
    public function getEmail(){ return $this->email; }

    /**
     * @return mixed Return le sel créé par une fonction
     */
    public function getSalt(){ return $this->salt; }

    /**
     * @return mixed Return le mot de passe du User
     */
    public function getPassword(){ return $this->password;}

    /**
     * Renvoie le mot de passe sécurisé (salé et itéré 10 mille fois) stocké en base de données
     * @param $entry le mot de passe pour lequel générer le mot de passe sécurisé
     * @return string le mot de passe sécurisé
     */
    public final static function getSecuredPassword($entry) {
        return hash('md5',$entry);
    }
    
    public final static function generateSalt()
    {
        return "";
    }

    /**
     * @param $entry le mot de passe
     * @return bool true si le mot de passe est valide
     */
    public function isPasswordValid($entry) {
        return $this->getSecuredPassword($entry) === $this->password;
    }
}
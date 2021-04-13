<?php
require_once('Maisons.php');
require_once('SqlConnection.php');

class MaisonsDAO
{
    private static $dao;

    private function __construct(){}
    
    public final static function getInstance(){
        if(!isset(self::$dao)){
            self::$dao = new MaisonsDAO();
        }
        return self::$dao;
    }

    public final function insert($houses,$id)
    {
        if($houses instanceof Maisons){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("INSERT INTO maison(id, nom, associateUser) VALUES(0, :name, :au)");
            $sth->bindValue(':name',$houses->getName());
            $sth->bindValue(':au', $id);
            $sth->execute();
        }
    }

    public final function findHouses($userId){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM maison WHERE associateUser = :au");
        $sth->bindValue(':au',$userId);
        $sth->execute();
        $houses = array();
        while($house = $sth->fetchObject(Maisons::class)) {
            $houses[] = $house;
        }
        return $houses;
    }

    public final function findOneHouse($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM maison WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
        return $sth->fetchObject(Maisons::class);
    }
    public final function findAll(){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM maison");
        $sth->execute();
        $houses = array();
        while($house = $sth->fetchObject(Maisons::class)) {
            $houses[] = $house;
        }
        return $houses;
    }

    public function delete($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("DELETE FROM maison WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
    }
}
?>
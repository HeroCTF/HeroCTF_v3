<?php
require_once('Livres.php');
require_once('SqlConnection.php');

class LivresDAO
{
    private static $dao;

    private function __construct(){}
    
    public final static function getInstance(){
        if(!isset(self::$dao)){
            self::$dao = new LivresDAO();
        }
        return self::$dao;
    }

    public final function insert($livres,$idUser,$idHouse)
    {
        if($livres instanceof Livres){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("INSERT INTO livres(id, titre, prix, auteur, associateUser, associateHouse, hasBeenRead, currentPage, maxPage) VALUES(0, :titre, :prix, :auteur, :au, :ah, :hbr, :cp, :mp)");
            $sth->bindValue(':titre',$livres->getTitre());
            $sth->bindValue(':prix',$livres->getPrix());
            $sth->bindValue(':auteur', $livres->getAuteur());
            $sth->bindValue(':au', $idUser);
            $sth->bindValue(':ah',$idHouse);
            $sth->bindValue(':hbr',0);
            $sth->bindValue(':cp',1);
            $sth->bindValue(':mp',$livres->getMaxPage());
            $sth->execute();
        }
    }

    public final function findLivres($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM livres WHERE associateUser = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
        $livres = array();
        while($livre = $sth->fetchObject(Livres::class)) {
            $livres[] = $livre;
        }
        return $livres;
    }

    public final function findOneBook($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM livres WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
        return $sth->fetchObject(Livres::class);
    }

    public final function findAll(){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM livres");
        $sth->execute();
        $livres = array();
        while($livre = $sth->fetchObject(Livres::class)) {
            $livres[] = $livre;
        }
        return $livres;
    }

    public function delete($id){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("DELETE FROM livres WHERE id = :id");
        $sth->bindValue(':id',$id);
        $sth->execute();
    }

    public function update($book,$idBook){
        if($book instanceof Livres){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("UPDATE livres SET hasBeenRead = :hbr, currentPage = :cp WHERE id = :id");
            $sth->bindValue(":hbr",$book->getHbr());
            $sth->bindValue(":cp",$book->getCp());
            $sth->bindValue(":id",$idBook);
            $sth->execute();
        }
    }
}
?>
<?php
require_once('User.php');
require_once('SqlConnection.php');

class UserDAO
{
    private static $dao;

    /**
     * UserDAO constructor of UserDAO
     */
    private function __construct(){}


    /**
     * @return UserDAO Instance of UserDAO (pattern used: Singleton)
     */
    public final static function getInstance(){
        if(!isset(self::$dao)){
            self::$dao = new UserDAO();
        }
        return self::$dao;
    }

    /**
     * Ajoute un utilisateur à la base de données
     * @param $user l'utilisateur à ajouter à la base de données
     */
    public final function insert($user)
    {
        if($user instanceof User){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("INSERT INTO users(id, pseudo, email, password, salt, isAdmin) VALUES(0, :pseudo, :mail, :password, :salt, 0)");
            $sth->bindValue(':mail',$user->getEmail());
            $sth->bindValue(':password',$user->getPassword());
            $sth->bindValue(':salt', $user->getSalt());
            $sth->bindValue(':pseudo', $user->getPseudo());
            $sth->execute();
        }
    }

    public final function findUser($mail){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM users WHERE email = :email");
        $sth->bindValue(':email',$mail);
        $sth->execute();
        return $sth->fetchObject(User::class);
    }

    public final function findAll(){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("SELECT * FROM users");
        $sth->execute();
        $users = array();
        while($user = $sth->fetchObject(User::class)) {
            $users[] = $user;
        }
        return $users;
    }

    public final function updatePassword($user){
        if($user instanceof User){
            $db = SqlConnection::getConnection();
            $sth = $db->prepare("UPDATE users SET pseudo=:pseudo, password = :pass, salt = :salt WHERE email = :email");
            $sth->bindValue(':pseudo',$user->getPseudo());
            $sth->bindValue(':pass',$user->getPassword());
            $sth->bindValue(':salt',$user->getSalt());
            $sth->bindValue(':email',$user->getEmail());
            $sth->execute();
        }
    }

    public final function updatePseudo($pseudo){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("UPDATE users SET pseudo=:pseudo WHERE email = :email");
        $sth->bindValue(':pseudo',$pseudo);
        $sth->bindValue(':email',$_SESSION['email']);
        $sth->execute();
    }

    public function delete($mail){
        $db = SqlConnection::getConnection();
        $sth = $db->prepare("DELETE FROM users WHERE email = :email");
        $sth->bindValue(':email',$mail);
        $sth->execute();
    }
}
?>
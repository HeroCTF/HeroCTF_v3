<?php
class SqlConnection {

    private static $connection;

    /**
     * SqliteConnection constructor.
     */
    public function __construct() {
        $dsn = 'mysql:host=' . getenv('MYSQL_HOST') . '; dbname=' . getenv('MYSQL_DATABASE') . ';';
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        try
        {
            self::$connection = new PDO($dsn, $user, $password);
        }
        catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Retourne la connexion de la base de données
     * @return Connection la connection à la base de données
     */
    public final static function getConnection() {
        if(!isset(self::$connection)) {
            new SqlConnection();
        }
        return self::$connection;
    }

}

?>

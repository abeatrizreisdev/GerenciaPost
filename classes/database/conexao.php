<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = 'localhost:3306';
        $db = 'gerenciapost';
        $user = 'root';
        $pass = '123456'; // Confirme se esta senha está correta

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Alterado para lançar exceção
            throw new Exception('Falha na conexão: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }

    private function __clone() {}
    public function __wakeup() {}
}
?>

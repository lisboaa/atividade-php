<?php
session_start();
class Banco {

    protected static $connection;

    protected static function connect() {
        try {
            self::$connection = new PDO('mysql:host=192.168.1.11:33066;dbname=atividade-php', 'root', 'root');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return self::$connection;
        } catch (Exception $exception) {
            echo "Falha na conexão com o banco de dados" .$exception->getMessage();
            exit();
        }

    }

    public static function getConnection() {
        return (self::$connection) ? self::$connection : self::connect();
    }
}
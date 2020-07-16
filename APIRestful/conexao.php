<?php
class Conexao{
    public static function conectar(){
        try {
            $conexao = new PDO("mysql:host=localhost;
            dbname=bdeasycare2", "root", ""); 
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao->exec("SET CHARACTER SET utf8");
            return $conexao;
        }catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
}
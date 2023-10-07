<?php 
    class Conexion{
        static public function conectar(){
            $link = new PDO("mysql:host=localhost;port=3308;dbname=4a-sag-wedding", "sotero-4a", "sotero29ag");
    
            $link->exec("set names utf8");
    
            return $link;
        } 
    }
    
?>
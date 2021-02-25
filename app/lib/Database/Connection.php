<?php

abstract class Connection{
    
    private static $conn;

    public static function getConn(){

        if(self::$conn == null){
            self::$conn = new PDO('mysql: host=seu_HOST; dbname=seu_DB;','seu_USUARIO','sua_SENHA');
        }

        return self::$conn;
    }
}
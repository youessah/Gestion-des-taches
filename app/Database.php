<?php

class Database{
    static private $db_host = '127.0.0.1';
    static private $db_name = 'gestiont_des_taches'; 
    static private $db_charset = 'utf8'; 
    static private $db_user = 'root'; 
    static private $db_password = ''; 
    static private $db = null; 

    static public function Connect(){
        try{
            self::$db = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name.';charset='.self::$db_charset,self::$db_user,self::$db_password);
        }catch(PDOException $e){
            die($e->getMessage());
        }

        return self::$db;
    }

    static public function Disconnect(){
        self::$db = null;
    }
}
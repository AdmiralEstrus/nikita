<?php

class Db
{
    public static function getConnection()
    {
        $paramPath = __DIR__ . '/../config/db_params.php';
        $params = include($paramPath);
        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset=UTF8";
            $db = new PDO($dsn, $params['user'], $params['password']);
        } catch (PDOException $exception) {
            print "Error! " . $exception->getMessage() . "<br>";
            die();
        }
        return $db;
    }
}
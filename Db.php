<?php
class Db{
    public static function getConnection(){
        // Получаем параметры подключения из файла
        $params = array('host' => 'localhost','dbname' => 'u600484323_dima','user' => 'u600484323_dima','password' => '123123');
        // Устанавливаем соединение
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        // Задаем кодировку
        $db->exec("set names utf8");
        return $db;
    }
}
<?php
    header('Content-Type: application/json');

    $username = 'root';   
    $password = '';      
    $host = 'localhost';
    $database = 'tjehu';
    $port = '3306';

    $db_conn = new mysqli($host, $username, $password, $database, $port) or die("Connect failed: %s\n". $conn -> error);
       
    return $db_conn;
?>
<?php
function connection(){
    $host = 'localhost';
    $username = 'root';
    $pwd = '';
    $dbname = 'universitymanagement';
    try {
        $dsn = 'mysql:host='.$host.';dbname='.$dbname.'';
        $pdo = new PDO($dsn, $username, $pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        echo "ERROR : ".$e->getMessage();
        die();
    }
}
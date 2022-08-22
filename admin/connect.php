<?php
    $dsn= 'mysql:host=localhost;dbname=shop';
    $user= 'root';
    $password= '';
    $option= array (
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con= new PDO($dsn,$user,$password,$option);
        $con->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    catch(PDOException $e){
        echo 'failed to connect' . $e->getMessage();
    }
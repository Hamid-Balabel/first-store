<?php

    function getTitle(){

        global $pageTitle;
        
        if(isset($pageTitle)){
            echo $pageTitle;
        } else{
            echo 'Default';
        }
    }

    // redirect to home page after errore

    function redirectHome($theMsg, $url= null, $seconds= 3){

        if($url === null){
            $link= 'Home page';
            $url= 'index.php';
        } else{
            $link= 'previous page';
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url= $_SERVER['HTTP_REFERER'];
            } else{
                $url= 'index.php';
            }
        }

        echo $theMsg;
        echo"<div class='alert alert-info'> you will be redirect to $link after $seconds second</div> ";
        
        header("refresh:$seconds;url=$url");
        exit();

    }

    // chekitems functions

    function checkItem($select, $from, $value){

        global $con;
        $stmt2= $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stmt2->execute(array($value));
        $count= $stmt2->rowCount();
        return $count;
    }

    //function to count items

    function countItems($item, $table){
        global $con;
        $stmt2= $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();
        
        return $stmt2->fetchColumn();
    }

    // to find the latest item

    function getLatest($select, $table, $order, $limit= 5){
        global $con;
        $stmt2= $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $stmt2->execute();
        $rows= $stmt2->fetchAll();
        return $rows;

    }
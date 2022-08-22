<?php

    $do=isset($_GET['do']) ? $_GET['do'] : 'manage';
    
    if ($do == 'manage'){

        echo 'welcome you are in manage category page';
        echo '<a href="?do=Add">Add new category +</a>';

    } elseif ($do== 'Add'){

        echo 'you are in Add page';

    } elseif ($do == 'insert'){

        echo 'you are in insert page';
    } else {

        echo 'EROR there\'s No page with this name';
    }

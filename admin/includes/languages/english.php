<?php
    function lang ($phrase){
        static $lang= array(
            'admin_area'=>'Hamid',
            'sections'=> 'Categories',
            'ITEMS'=> 'items',
            'MEMBERS'=> 'members',
            'STATISTICS'=> 'statistics',
            'LOGS'=> 'logs'
        );
        return $lang [$phrase];
    }
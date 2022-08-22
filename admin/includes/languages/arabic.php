<?php
    function lang ($phrase){
        static $lang= array(
            'message'=> 'أهـلا',
            'admin'=> 'حميد'
        );
        return $lang [$phrase];
    }
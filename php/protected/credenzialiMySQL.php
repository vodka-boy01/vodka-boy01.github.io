<?php
    if(($_SERVER['HTTP_HOST'] === 'localhost:3000') || ($_SERVER['HTTP_HOST'] === 'localhost')){
        //pc localhost:3000 da vviare con php serve su vs code
        //localhost standard address per mysql 
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASSWORD', '');
        define('DATABASE', 'luigi_tanzillo');

    }else{
        //server inifinity free
        define('HOST', 'sql208.infinityfree.com');
        define('USER', 'if0_38885359');
        define('PASSWORD', '78421789');
        define('DATABASE', 'if0_38885359_XXX');

    }
?>
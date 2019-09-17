<?php

// MYSQL configuration
if(true){
    define('DB_NAME', 'moodle');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', '127.0.0.1');
    define('TABLE_PREFIX','mdl_');
}else{
    define('DB_NAME', 'moodle');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'password');
    define('DB_HOST', '127.0.0.1');
    define('TABLE_PREFIX','mdl_');
}

?>

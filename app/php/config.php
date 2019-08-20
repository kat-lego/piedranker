<?php

// MYSQL configuration
if($_SERVER['SSH_CLIENT'] == '10.10.187.45 47110 22'){
    define('DB_NAME', 'moodle');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'password');
    define('DB_HOST', '127.0.0.1');
    define('TABLE_PREFIX','mdl_');
}else{
    define('DB_NAME', 'moodle');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', '127.0.0.1');
    define('TABLE_PREFIX','mdl_');
}

?>

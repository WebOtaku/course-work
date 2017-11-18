<?php
   /**
    * Configuration File
    * Contain config for PHP
    * Connecting to Data Base
    */

    define("DB_HOST", "localhost");
    define("DB_USER", "vlad");
    define("DB_PASSWORD", "123");
    define("DB_NAME", "distance_learning_system");

    $db = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($db -> connect_errno) {
        die("Ошибка подключения: " . $php_errormsg);
    }

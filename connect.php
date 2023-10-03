<?php
    $options = 
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=library', 'root', '', $options);
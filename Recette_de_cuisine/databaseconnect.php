<?php

try {
    $mysqlClient = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lecture du fichier SQL
    $sql = file_get_contents(__DIR__.'/sql/add_comments.sql');

    // Exécution du SQL
    $mysqlClient->exec($sql);

} catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
}
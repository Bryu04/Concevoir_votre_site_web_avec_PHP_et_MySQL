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

    // Ajoute les colones dates et review:
    $sql2 = file_get_contents(__DIR__.'/sql/improve_comments.sql');

    // On vérifie si les colonnes existent déjà
    $result = $mysqlClient->query("SHOW COLUMNS FROM comments LIKE 'created_at'");
    $columnExists = $result->rowCount() > 0;
    // Exécution du SQL

    if (!$columnExists) {
        // Les columns n'existent pas, donc faut les créer
        $mysqlClient->exec($sql2);
    }
    

} catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
}
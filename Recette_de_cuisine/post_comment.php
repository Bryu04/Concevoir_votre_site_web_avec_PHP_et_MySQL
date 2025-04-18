<?php 

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');
require_once(__DIR__ . '/functions.php');

// Vérification du formulaire soumis
if (
    empty($_POST['comment'])
    )
{
    echo 'Le commentaire ne peut pas être vide';
    return;
}

$userId = $_SESSION['LOGGED_USER']['user_id'];
$recipeId = $_POST['id'];
$comment = $_POST['comment'];

// Faire l'insertion en base
$insertComment = $mysqlClient->prepare('INSERT INTO comments (user_id, recipe_id, comment) VALUES (:user_id, :recipe_id, :comment)');
$insertComment->execute([
    'user_id' => $userId,
    'recipe_id' => $recipeId,
    'comment' => $comment,
]);

redirectToUrl('recipes_read.php?id='.$recipeId);

?>
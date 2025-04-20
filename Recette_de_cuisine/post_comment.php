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
$rating = isset($_POST['rating']) && is_numeric($_POST['rating']) ? (int) $_POST['rating'] : null;


// Faire l'insertion en base
$insertComment = $mysqlClient->prepare('INSERT INTO comments (user_id, recipe_id, comment, review) VALUES (:user_id, :recipe_id, :comment, :review)');
$insertComment->execute([
    'user_id' => $userId,
    'recipe_id' => $recipeId,
    'comment' => $comment,
    'review' => $rating,
]);

redirectToUrl('recipes_read.php?id='.$recipeId);

?>
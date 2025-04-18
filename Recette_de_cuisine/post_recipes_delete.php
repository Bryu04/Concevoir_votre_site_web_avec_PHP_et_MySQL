<?php 

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');
require_once(__DIR__ . '/functions.php');

// Vérification du formulaire soumis
if (
    !isset($_POST['id']) || !is_numeric($_POST['id'])
    )
{
    echo 'Il manque des informations pour permettre l\' édition du formulaire.';
    return;
}

$id = $_POST['id'];

$deleteRecipe = $mysqlClient->prepare('DELETE FROM recipes WHERE recipe_id = :id');
$deleteRecipe->execute([
    'id' => $id,
]);

redirectToUrl('index.php');
?>
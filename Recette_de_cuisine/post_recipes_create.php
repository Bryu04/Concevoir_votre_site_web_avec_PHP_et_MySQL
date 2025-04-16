<?php 

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');

// Vérification du formulaire soumis
if (
    empty($_POST['title'])
    || empty($_POST['recipe'])
    )
{
    echo 'Il faut un titre et une recette pour soumettre le formulaire.';
    return;
}

$title = $_POST['title'];
$recipe = $_POST['recipe'];

// Faire l'insertion en base
$insertRecipe = $mysqlClient->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['email'],
]);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Création de recette </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body> 
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Recette ajoutée avec succès !</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo($title); ?></h5>
                <p class="card-text"><b>Email</b> : <?php echo($_SESSION['LOGGED_USER']['email']); ?></p>
                <p class="card-text"><b>Recette</b> : <?php echo(strip_tags($recipe)); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
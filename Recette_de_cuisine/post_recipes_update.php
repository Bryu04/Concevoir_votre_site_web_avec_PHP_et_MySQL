<?php 

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');

// Vérification du formulaire soumis
if (
    !isset($_POST['id']) || !is_numeric($_POST['id'])
    || empty(trim($_POST['title']))
    || empty(trim($_POST['recipe']))
    )
{
    echo 'Il manque des informations pour permettre l\' édition du formulaire.';
    return;
}

$id = $_POST['id'];
$title = $_POST['title'];
$recipe = $_POST['recipe'];

// Faire l'insertion en base
$updateRecipe = $mysqlClient->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
$updateRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
]);

// Double vérification du modification
if ($updateRecipe->rowCount() > 0) {
    // succès
} else {
    echo "La recette n’a pas été modifiée (vérifiez que vous avez changé quelque chose).";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Edition de recette </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body> 
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Recette modifiée avec succès !</h1>
        
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
<?php

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');
require_once(__DIR__ .'/functions.php');

$getData = $_GET;

if (!isset($getData['id']) && is_numeric($getData['id']))
{
    echo("Il faut un identifiant de recette pour le lire.");
    return;
}

$retrieveRecipeStatement = $mysqlClient->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$retrieveRecipeStatement->execute([
    'id' => $getData['id'],
]);

$recipe = $retrieveRecipeStatement->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Détails du recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Détails sur la recette : <?php echo($recipe['title']); ?></h1>
        <i>Recette de <?php echo displayAuthor($recipe['author'], $users); ?></i>
        <br />
        <p><?php echo $recipe['recipe']; ?></p>
        <br />
        <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a class="link-info" href="index.php">Retour à la page d'accueil</a></li>
                        <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                        <li class="list-group-item"><a class="link-warning" href="recipes_update.php?id=<?php echo($recipe['recipe_id']); ?>">Editer l'article</a></li>
                        <li class="list-group-item"><a class="link-danger" href="recipes_delete.php?id=<?php echo($recipe['recipe_id']); ?>">Supprimer l'article</a></li>
                        <?php endif; ?>
        </ul>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>
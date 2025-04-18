<?php

session_start();
include_once(__DIR__.'/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
include_once(__DIR__.'/variables.php');

$getData = $_GET;

if (!isset($getData['id']) && is_numeric($getData['id']))
{
    echo("Il faut un identifiant de recette pour le modifier.");
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
    <title>Site de Recettes - Supprimer la recette ?</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Supprimer la recette : <?php echo($recipe['title']); ?> ?</h1>
        <form action="post_recipes_delete.php" method="POST">
            <div class="mb-3 visually-hidden">
                <label for="id" class="form-label">identifiant de la recette</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo($recipe['recipe_id']); ?>">
            </div>
            
            <button type="submit" class="btn btn-danger">La suppression est définitive</button>
        </form>
        <br />
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>


</html>
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

// Récupérer les commentaires sur la recette

$commentsRecipeStatement = $mysqlClient->prepare('
        SELECT u.full_name, c.comment, DATE_FORMAT(c.created_at, "%d/%m/%Y") AS comment_date
        FROM recipes r 
        INNER JOIN comments c ON c.recipe_id = r.recipe_id 
        INNER JOIN users u ON u.user_id = c.user_id 
        WHERE r.recipe_id = :id
        ORDER BY c.created_at DESC
');

$commentsRecipeStatement->execute([
    'id' => $getData['id'],
]);

$comments = $commentsRecipeStatement->fetchALL(PDO::FETCH_ASSOC);

$ratingStatement = $mysqlClient->prepare('
        SELECT AVG(c.review) as rating
        FROM recipes r
        INNER JOIN comments c ON c.recipe_id = r.recipe_id
        WHERE r.recipe_id = :id AND c.review IS NOT NULL
');

$ratingStatement->execute([
    'id' => $getData['id'],
]);

$averageRating = $ratingStatement->fetchColumn();

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
        <h1>Détails sur la recette : <?php echo($recipe['title']); ?>
            (<small>
                <em>
                    <?php if ($averageRating) : ?>
                        Note moyenne :  <?php echo(round($averageRating, 1) ); ?>  / 5 ⭐
                    <?php else : ?>
                        Aucune note pour cette recette
                    <?php endif; ?>
                </em>
            </small>)
        </h1>
        <i>Recette de <?php echo displayAuthor($recipe['author'], $users); ?></i>
        <br />
        <p><?php echo $recipe['recipe']; ?></p>
        <br />
        <h3>Section de commentaires</h3>
        <?php if (count($comments) > 0) : ?>
        <article>
            <ul>
                <?php foreach ($comments as $comment) : ?>
                    <li>
                        <strong><?php echo($comment['full_name']); ?> (<?php echo($comment['comment_date']); ?>) : </strong> <?php echo($comment['comment']); ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </article>
        <?php else : ?>
            <p>Aucun commentaire.</p>
        <?php endif; ?>
        <br />
        <?php // Rajoute un formulaire visible pour ceux qui est connecté ?>
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            <form action="post_comment.php" method="POST">
            <div class="mb-3 visually-hidden">
                <label for="id" class="form-label">identifiant du commentaire</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo($recipe['recipe_id']); ?>">
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label"><strong>Ajouter une note</strong></label>
                <select name="rating" id="rating" class="form-select">
                    <option value="">-- Choisir une note --</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label"><strong>Ajouter un commentaire</strong></label>
                <textarea class="form-control" placeholder="Ecrivez un commentaire !!" id="comment" name="comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Commentez</button>
        </form>
        <?php endif; ?>
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
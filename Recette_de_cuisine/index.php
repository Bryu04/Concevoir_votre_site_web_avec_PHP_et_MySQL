<?php 

session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');
require_once(__DIR__ .'/variables.php');
require_once(__DIR__ .'/functions.php');

// Si Cookie est expiré, on met fin à la session 
// if (!isset($_COOKIE['LOGGED_USER'])) {
//     redirectToUrl('logout.php');
// }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Site de recettes</h1>

        <!-- Formulaire de connexion -->
        <?php require_once(__DIR__ . '/login.php'); ?>

            <?php foreach (getRecipes($recipes) as $recipe) : ?>
                <article>
                <a href="recipes_read.php?id=<?php echo($recipe['recipe_id']); ?>"><h3><?php echo $recipe['title']; ?></h3></a>
                    <i><?php echo displayAuthor($recipe['author'], $users); ?></i>        
                </article>
            <?php endforeach ?>
    </div>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>
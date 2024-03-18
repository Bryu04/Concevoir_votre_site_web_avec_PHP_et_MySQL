<?php 

// Dans ce fichier nous allons créer une page de recette de cuisine

// On veut 4 recettes venant de 4 utilisateur different.

// $recipes = [
//     [
//         'title' => 'Blanquet de veau',
//         'author' => 'Didier Mamourn', 
//         'email' => 'didier.mamourn@example.com',
//     ],
//     [ 
//         'title' => 'Grattin de Dauphinois',
//         'author' => 'Jean Salaur', 
//         'email' => 'jean.salaur@example.com',
//     ],
//     [   
//         'title' => 'Salade de fruits exotiques',
//         'author' => 'Kevin Renard', 
//         'email' => 'kevin.renard@example.com',
//     ],
//     [
//         'title' => 'Lasagnes aux épinards',
//         'author' => 'Salomon Gregoire', 
//         'email' => 'salomon.gregoire@example.com',
//     ],
// ];

$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' => 'Etape 1 : des flageolets !',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Couscous',
        'recipe' => 'Etape 1 : de la semoule',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => false,
    ],
    [
        'title' => 'Escalope milanaise',
        'recipe' => 'Etape 1 : prenez une belle escalope',
        'author' => 'mathieu.nebra@exemple.com',
        'is_enabled' => true,
    ],
];


?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des recettes</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
    >
</head>
<body>
    <h1>Affichage des recettes</h1>
    <?php
    foreach ($recipes as $recipe) {
        if (array_key_exists('is_enabled', $recipe) && 
            $recipe['is_enabled']) {
            echo '<h2>'.$recipe['title'].'</h2>';
            echo $recipe['recipe'].'<br/>';
            echo '<i>'.$recipe['author'].'</i>';
        }
        
    }
    ?>
</body>
</html>
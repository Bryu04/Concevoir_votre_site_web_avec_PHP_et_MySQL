<?php 

// Dans ce fichier nous allons créer une page de recette de cuisine

// On veut 4 recettes venant de 4 utilisateur different.

$recipes = [
    [
        'title' => 'Blanquet de veau',
        'author' => 'Didier Mamourn', 
        'email' => 'didier.mamourn@example.com',
    ],
    [ 
        'title' => 'Grattin de Dauphinois',
        'author' => 'Jean Salaur', 
        'email' => 'jean.salaur@example.com',
    ],
    [   
        'title' => 'Salade de fruits exotiques',
        'author' => 'Kevin Renard', 
        'email' => 'kevin.renard@example.com',
    ],
    [
        'title' => 'Lasagnes aux épinards',
        'author' => 'Salomon Gregoire', 
        'email' => 'salomon.gregoire@example.com',
    ],
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Affichage des recettes</title>
</head>
<body>
    <ul>
        <?php for ($lines = 0; $lines <= 3; $lines++): ?>
            <li><?php echo $recipes[$lines]['title'] . ' (' . $recipes[$lines]['author'] . ')'; ?></li>
        <?php endfor; ?>
    </ul>
</body>
</html>
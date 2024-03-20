<?php
$users = [
    [
        'full_name' => 'Mickaël Andrieu',
        // 1e erreur: On a oublié de mettre un coma à la fin de l'email
        'email' => 'mickael.andrieu@exemple.com',
        'age' => 34,
    ],
    [
        'full_name' => 'Mathieu Nebra',
        'email' => 'mathieu.nebra@exemple.com',
        'age' => 34,
    ],
    [
        'full_name' => 'Laurène Castor',
        'email' => 'laurene.castor@exemple.com',
        'age' => 28,
    ],
];

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
    [
        'title' => 'Salade Romaine',
        'recipe' => 'Etape 1 : prenez une belle salade',
        // 3e erreur: L'email ici dans la recette n'est pas le même que dans le tableau des users
        'author' => 'laurene.castor@exemple.com',
        'is_enabled' => true,
    ],
];

function displayAuthor(string $authorEmail, array $users): string
    {
        //var_dump($authorEmail); die();
        foreach($users as $user) {
            if ($authorEmail === $user['email']) {
                return $user['full_name'] . '(' . $user['age'] . ' ans)';
            }
        }
    }
function isValidRecipe(array $recipe): bool
    {
        //2e erreur: Ici l'erreur se trouve dans la clé plus haut, le 'is_enabled est mal écrit dans la recette de Salade Romaine
        return $recipe['is_enabled'];
    }
function getRecipes(array $recipes) : array
    {
        $valid_recipes = [];
        foreach($recipes as $recipe) {
            if (isValidRecipe($recipe)) {
                $valid_recipes[] = $recipe;
            }
        }
    return $valid_recipes;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 4e erreur ? : Le parenthèse ici ne sert à rien  -->
    <title>Recettes de cuisine : Erreur Corrigé </title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <h1>Liste des recettes de cuisine</h1>
        <?php foreach(getRecipes($recipes) as $recipe) : ?>
        <article>
            <h3><?php echo($recipe['title']); ?></h3>
            <div><?php echo($recipe['recipe']); ?></div>
            <i><?php echo(displayAuthor($recipe['author'], $users)); ?></i>
        </article>
        <?php endforeach ?>
    </div>
</body>
</html>
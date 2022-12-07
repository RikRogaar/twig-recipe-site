<?php

require_once 'vendor/autoload.php';

use RedBeanPHP\R as R;

$dbhost = "localhost";
$dbname = "your-fullstack-framework";
$dbuser = "bit_academy";
$dbpass = "bit_academy";

R::setup("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

$recipesCounter = 0;
$kitchenCounter = 0;

$recipes = [
    [
        'id'    => 1,
        'name'  => 'Pannekoeken',
        'type'  => 'dinner',
        'level' => 'easy',
        'kitchen' => 3
    ],
    [
        'id'    => 24,
        'name'  => 'Tosti',
        'type'  => 'lunch',
        'level' => 'easy',
        'kitchen' => 1
    ],
    [
        'id'    => 36,
        'name'  => 'Boeren ommelet',
        'type'  => 'lunch',
        'level' => 'easy',
        'kitchen' => 3
    ],
    [
        'id'    => 47,
        'name'  => 'Broodje Pulled Pork',
        'type'  => 'lunch',
        'level' => 'hard',
        'kitchen' => 1
    ],
    [
        'id'    => 5,
        'name'  => 'Hutspot met draadjesvlees',
        'type'  => 'dinner',
        'level' => 'medium',
        'kitchen' => 3
    ],
    [
        'id'    => 6,
        'name'  => 'Nasi Goreng met Babi ketjap',
        'type'  => 'dinner',
        'level' => 'hard',
        'kitchen' => 2
    ],
];

$kitchens = [
    [
        'id' => 1,
        'name' => 'Franse keuken',
        'description' => 'De Franse keuken is een internationaal gewaardeerde keuken met een lange traditie. Deze
            keuken wordt gekenmerkt door een zeer grote diversiteit, zoals dat ook wel gezien wordt in de Chinese
            keuken en Indische keuken.',
    ],
    [
        'id' => 2,
        'name' => 'Chineese keuken',
        'description' => 'De Chinese keuken is de culinaire traditie van China en de Chinesen die in de diaspora
            leven, hoofdzakelijk in Zuid-Oost-Azië. Door de grootte van China en de aanwezigheid van vele volkeren met
            eigen culturen, door klimatologische afhankelijkheden en regionale voedselbronnen zijn de variaties groot.',
    ],
    [
        'id' => 3,
        'name' => 'Hollandse keuken',
        'description' => 'De Nederlandse keuken is met name geïnspireerd door het landbouwverleden van Nederland.
             Alhoewel de keuken per streek kan verschillen en er regionale specialiteiten bestaan, zijn er voor
             Nederland typisch geachte gerechten. Nederlandse gerechten zijn vaak relatief eenvoudig en voedzaam,
             zoals pap, Goudse kaas, pannenkoek, snert en stamppot.',
    ],
    [
        'id' => 4,
        'name' => 'Mediterraans',
        'description' => 'De mediterrane keuken is de keuken van het Middellandse Zeegebied en bestaat onder
            andere uit de tientallen verschillende keukens uit Marokko,Tunesie, Spanje, Italië, Albanië en Griekenland
            en een deel van het zuiden van Frankrijk (zoals de Provençaalse keuken en de keuken van Roussillon).',
    ],
];

R::nuke();

foreach ($kitchens as $kitchen) {
    $newKitchen = R::dispense('kitchens');
    $newKitchen->name = $kitchen['name'];
    $newKitchen->description = $kitchen['description'];
    R::store($newKitchen);
    $kitchenCounter++;
}

foreach ($recipes as $recipe) {
    $newRecipe = R::dispense('recipes');
    $newRecipe->name = $recipe['name'];
    $newRecipe->type = $recipe['type'];
    $newRecipe->level = $recipe['level'];
    $newRecipe->kitchen = R::load('kitchens', $recipe['kitchen']);
    R::store($newRecipe);
    $recipesCounter++;
}

$newUser = R::dispense('users');
$newUser->username = 'admin';
$newUser->password = password_hash('admin', PASSWORD_DEFAULT);
R::store($newUser);

echo 'Cleared recipes table and added ' . $recipesCounter . ' recipes to the recipes table' . PHP_EOL;
echo 'Cleared kitchens table and added ' . $kitchenCounter . ' kitchens to the kitchens table' . PHP_EOL;
echo 'Cleared users table and added a new user to the users table' . PHP_EOL;

R::close();
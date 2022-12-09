<?php

require_once '../vendor/autoload.php';

use RedBeanPHP\R as R;

const LEVELS = [
    'easy' => 'easy',
    'medium' => 'medium',
    'hard' => 'hard',
];

const TYPE = [
    'breakfast' => 'breakfast',
    'lunch' => 'lunch',
    'dinner' => 'dinner',
];

class RecipeController extends BaseController
{
    public function __construct()
    {
      $this->user = $_SESSION['user'] ?? null;
    }

    public function index()
    {
        global $twig;

        $recipes = R::findAll('recipes');
        echo $twig->render('recipes/index.twig', [
            'recipes' => $recipes,
            'user' => $this->user,
        ]);
    }

    public function show()
    {
        global $twig;

        $id = $_GET['id'];
        $bean = $this->getBeanById('recipes', $id);
        $kitchen = R::findOne('kitchens', 'id = ?', [$bean->kitchen_id]);

        if (!$bean) {
            error(404, 'Recipe not found');
        } else {
            echo $twig->render('recipes/show.twig', [
                'recipe' => $bean,
                'kitchen' => $kitchen,
            ]);
        }
    }

    public function create()
    {
        global $twig;

            echo $twig->render('recipes/create.twig', [
                'levels' => LEVELS,
                'types' => TYPE,
                'kitchens' => R::findAll('kitchens'),
            ]);
    }

    public function createPost()
    {
        $recipe = R::dispense('recipes');
        $recipe->name = $_POST['name'];
        $recipe->type = $_POST['type'];
        $recipe->level = $_POST['level'];
        $recipe->kitchen_id = $_POST['kitchen_id'];
        $id = R::store($recipe);
        header('Location: /recipe/show?id=' . $id);
    }

    public function edit()
    {
        global $twig;

        $id = $_GET['id'];
        $bean = $this->getBeanById('recipes', $id);
        if (!$bean) {
            error(404, 'Recipe not found');
        } else {
            echo $twig->render('recipes/edit.twig', [
                'recipe' => $bean,
                'levels' => LEVELS,
                'types' => TYPE,
                'kitchens' => R::findAll('kitchens'),
            ]);
        }
    }

    public function editPost()
    {
        $id = $_GET['id'];
        $bean = $this->getBeanById('recipes', $id);
        if (!$bean) {
            error(404, 'Recipe not found');
        } else {
            $bean->name = $_POST['name'];
            $bean->type = $_POST['type'];
            $bean->level = $_POST['level'];
            $bean->kitchen_id = $_POST['kitchen_id'];
            R::store($bean);
            header('Location: /recipe/show?id=' . $id);
        }
    }
}

R::close();
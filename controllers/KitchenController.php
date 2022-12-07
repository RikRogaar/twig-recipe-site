<?php

require_once '../vendor/autoload.php';

use RedBeanPHP\R as R;

class KitchenController extends BaseController
{
    public function index()
    {
        global $twig;

        $kitchens = R::findAll('kitchens');
        echo $twig->render('kitchens/index.twig', [
            'kitchens' => $kitchens,
        ]);
    }

    public function show()
    {
        global $twig;

        $id = $_GET['id'];
        $bean = $this->getBeanById('kitchens', $id);
        $recipes = R::find('recipes', 'kitchen_id = ?', [$id]);
        if (!$bean) {
            error(404, 'Kitchen not found');
        } else {
            echo $twig->render('kitchens/show.twig', [
                'kitchen' => $bean,
                'recipes' => $recipes,
            ]);
        }
    }

    public function create()
    {
        global $twig;

        echo $twig->render('kitchens/create.twig');
    }

    public function createPost()
    {
        $kitchen = R::dispense('kitchens');
        $kitchen->name = $_POST['name'];
        $kitchen->description = $_POST['description'];
        $id = R::store($kitchen);
        header('Location: /kitchen/show?id=' . $id);
    }

    public function edit()
    {
        global $twig;

        $id = $_GET['id'];
        $bean = $this->getBeanById('kitchens', $id);
        if (!$bean) {
            error(404, 'Kitchen not found');
        } else {
            echo $twig->render('kitchens/edit.twig', [
                'kitchen' => $bean,
            ]);
        }
    }

    public function editPost()
    {
        $id = $_GET['id'];
        $bean = $this->getBeanById('kitchens', $id);
        if (!$bean) {
            error(404, 'Kitchen not found');
        } else {
            $bean->name = $_POST['name'];
            $bean->description = $_POST['description'];
            R::store($bean);
            header('Location: /kitchen/show?id=' . $id);
        }
    }
}

R::close();
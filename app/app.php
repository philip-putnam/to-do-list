<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Tasks.php";
    require_once __DIR__."/../src/Category.php";

    // session_start();
    //
    // if (empty($_SESSION['list_of_tasks'])) {
    //     $_SESSION['list_of_tasks'] = array();
    // }

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {

        return $app['twig']->render('index.html.twig');
    });

    $app->get("/tasks", function() use ($app) {

        return $app['twig']->render('tasks.html.twig', array('tasks' => Tasks::getAll()));
    });

    $app->get("/categories", function() use ($app) {

        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/tasks", function() use ($app) {
        $task = new Tasks($_POST['description']);
        $task->save();
        return $app['twig']->render('tasks.html.twig', array('task' => Task::getAll()));
    });

    $app->post("/delete_tasks", function() use ($app) {
        Tasks::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>

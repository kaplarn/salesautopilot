<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require dirname(__FILE__) . '/../vendor/autoload.php';

$config =
    [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
                
        'database' =>
            [
                'host' => getenv('DATABASE_HOST'),
                'user' => getenv('DATABASE_USER'),
                'password' => getenv('DATABASE_PASSWORD'),
                'database' => 'salesautopilot'
            ]
    ];

$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();

$container['database'] = function($c)
{
    $db = $c['settings']['database'];
    
    $pdo = new \PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['user'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        dirname(__FILE__) . '/../src/View',
        ['cache' => false]
    );
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$app->get('/', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Dashboard\DisplayController($this->view);
    $controller->setUserMapper(new \SalesAutoPilot\Mapper\UserMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    $controller->setIssueMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    
    return $controller->action($request, $response);
});

$app->get('/status/list', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusListController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/status/create', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusCreateFormController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->post('/status/create', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusCreateController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/status/edit/{id}', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusEditFormController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->post('/status/edit/{id}', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusEditController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/status/remove/{id}', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Status\StatusRemoveController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\StatusMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/issue/list', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Issue\IssueListController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/issue/create', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Issue\IssueCreateFormController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    $controller->setUserMapper(new \SalesAutoPilot\Mapper\UserMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    
    return $controller->action($request, $response);
});

$app->post('/issue/create', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Issue\IssueCreateController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    $controller->setUserMapper(new \SalesAutoPilot\Mapper\UserMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    
    return $controller->action($request, $response);
});

$app->get('/issue/edit/{id}', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Issue\IssueEditFormController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    $controller->setUserMapper(new \SalesAutoPilot\Mapper\UserMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    
    return $controller->action($request, $response);
});

$app->post('/issue/edit/{id}', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Issue\IssueEditController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    $controller->setUserMapper(new \SalesAutoPilot\Mapper\UserMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    
    return $controller->action($request, $response);
});

$app->get('/issue/remove/{id}', function (Request $request, Response $response) {
    $controller = new \SalesAutoPilot\Controller\Issue\IssueRemoveController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($this->get('database')));
    
    return $controller->action($request, $response);
});

$app->get('/issue/statusupdate/{id}/{statusId}', function (Request $request, Response $response) {
    $database = $this->get('database');
    
    $controller = new \SalesAutoPilot\Controller\Issue\IssueStatusUpdateController($this->view);
    $controller->setMapper(new \SalesAutoPilot\Mapper\IssueMapper($database));
    $controller->setStatusMapper(new \SalesAutoPilot\Mapper\StatusMapper($database));
    
    return $controller->action($request, $response);
});


$app->run();
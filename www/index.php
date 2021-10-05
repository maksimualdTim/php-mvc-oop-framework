<?php
    spl_autoload_register(function (string $className){
        require_once __DIR__.'/../src/'.str_replace('\\', '/', $className).'.php'; 
    });
    // $controller = new my_project\controllers\MainController();

    $route=$_GET['route'] ?? '';
    $routes=require __DIR__.'/../src/routes.php';

    $isRouteFound=false;
    foreach($routes as $pattern => $controllerAndAction){
        preg_match($pattern, $route, $matches);
        if (!empty($matches)){
            $isRouteFound=true;
            break;
        }
    }
    if (!$isRouteFound){
        echo 'Страница не найдена!';
        return;
    }

    $controllerName=$controllerAndAction[0];
    $actionName=$controllerAndAction[1];
    unset($matches[0]);
    
    $controller=new $controllerName();
    $controller->$actionName(...$matches);
    

    // $pattern = '~^hello/(.*)$~';
    // preg_match($pattern, $route, $matches);
    // if (!empty($matches)){
    //     $controller = new \my_project\controllers\MainController();
    //     $controller->sayHello($matches[1]);
    //     return;
    // }

    // $pattern = '~^$~';
    // preg_match($pattern, $route, $matches);
    // if (!empty($matches)){
    //     $controller = new \my_project\controllers\MainController();
    //     $controller->main();
    //     return;
    // }
    
?>
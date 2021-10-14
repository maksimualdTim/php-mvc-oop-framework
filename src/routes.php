<?php
return [
    '~^articles/(\d+)$~' => [\my_project\controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\my_project\controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/add$~' => [\my_project\controllers\ArticlesController::class, 'add'],
    '~^$~' => [\my_project\controllers\MainController::class, 'main'],
];
?>
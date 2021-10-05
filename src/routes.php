<?php
return [
    '~^articles/(\d+)$~' => [\my_project\controllers\ArticlesController::class, 'view'],
    '~^$~' => [\my_project\controllers\MainController::class, 'main'],
];
?>
<?php
    namespace my_project\controllers;
    use my_project\View\View;
    use services\Db;
    use my_project\models\articles\Article; 
    class ArticlesController{
        private $db;
        private $view;

        public function __construct()
        {
            $this->view = new View(__DIR__.'/../../templates');
            $this->db = new Db();
        }
        public function view(int $articleId){
           $result=Article::getById($articleId);
        //    var_dump($result);

                if($result === NULL){
                    $this->view->renderHtml('errors/404.php', [], 404);
                    return;
                }

                $this->view->renderHtml('articles/view.php', ['article' => $result]);
        }
    }
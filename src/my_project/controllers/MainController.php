<?php
    namespace my_project\controllers;
    use my_project\View\View;
    
    use my_project\models\articles\Article;
    class MainController{
        private $db;
        private $view;

        public function __construct()
        {
            $this->view = new View(__DIR__.'/../../templates');
        }

        public function main() {
            $articles=Article::findAll();
            // var_dump($articles);
            $this->view->renderHtml('main/main.php', ['articles'=>$articles]);
        
    }


    }
?>
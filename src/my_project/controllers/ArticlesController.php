<?php
    namespace my_project\controllers;
    use my_project\View\View;
    use my_project\models\articles\Article;
use my_project\models\users\User;

class ArticlesController{
        private $view;

        public function __construct()
        {
            $this->view = new View(__DIR__.'/../../templates');
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
        public function edit($articleId){
            $article=Article::getById($articleId);
            if($article === NULL){
                $this->view->renderHtml('errors/404.php', [], 404);
                return;
            }
            $article->setName('Как купить бананы?');
            $article->setText('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi earum 
            laboriosam soluta expedita nobis sapiente ut recusandae repellat voluptates consequuntur dolorum, 
            ipsum eum error odit, ad possimus ullam magni nam?');

            $article->save();

        }
        
        public function add()
        {
            $authorName = User::getById(1);
            $article = new Article();
            $article->setName('test add new article');
            $article->setText('test add new article text');
            $article->setAuthor($authorName);

            $article->save();
        }
    }
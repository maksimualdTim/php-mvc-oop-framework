<?php
namespace my_project\models\articles;
use my_project\models\ActiveRecordEntity;
use my_project\models\users\User;

class Article extends ActiveRecordEntity {
    protected $name, $text, $authorId, $createdAt;

    
    public function getName() :string{
        return $this->name;
    }
    public function getText() :string{
        return $this->text;
    }

    public function getAuthor() :User{
        return User::getById($this->authorId);
    }

    protected static function getTableName() :string{
        return 'articles';
    }
}
?>
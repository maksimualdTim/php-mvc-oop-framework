<?php
    namespace my_project\models;   
    use services\Db; 
    abstract class ActiveRecordEntity{
        protected $id;
        public function getId() :int{
            return $this->id;
        }
        public function __set($name, $value){
            $camelCase=$this->underscoreToCamelCase($name);
            $this->$camelCase=$value;
        }

        private function underscoreToCamelCase(string $source) :string{
            return lcfirst(str_replace('_','', ucwords($source, '_')));
        }
        public static function findAll():array{
            $db = new Db();
            return $db->query( 'SELECT * FROM `'.static::getTableName().'`;', [],static::class);
        }

        public static function getById ($id) : ?self{
            $db= new Db();
            $entities = $db->query(
                'SELECT * FROM `'.static::getTableName().'` WHERE id = :id;',
                [':id' => $id],
                static::class);
            return $entities ? $entities[0] : null;
            
        }
        abstract protected static function getTableName() :string;
    }
?>
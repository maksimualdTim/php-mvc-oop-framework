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
            $db = Db::getInstance();
            return $db->query( 'SELECT * FROM `'.static::getTableName().'`;', [],static::class);
        }

        public static function getById ($id) : ?self{
            $db = Db::getInstance();
            $entities = $db->query(
                'SELECT * FROM `'.static::getTableName().'` WHERE id = :id;',
                [':id' => $id],
                static::class);
            return $entities ? $entities[0] : null;
            
        }
        abstract protected static function getTableName() :string;

        private function camelCaseToUnderscore(string $source) :string{
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
        }
        public function save():void{
            $mappedProperties = $this->mapPropertiesToDbFormat();
            if ($this->id){
                $this->update($mappedProperties);
            }
            else{
                $this->insert($mappedProperties);
            } 
        }
        private function update($mappedProperties) :void{
            $columnsToParams = [];
            $paramsToValues = [];
            $index=1;
            foreach ($mappedProperties as $column => $value){
                $param = ":param" . $index;
                $columnsToParams[] = $column . '=' . $param;
                $paramsToValues[$param]=$value;
                $index++;
            }
            $sql='UPDATE '.static::getTableName().' SET '.implode(',',$columnsToParams).' WHERE id = '.$this->id;
            $db= Db::getInstance();
            $db->query($sql, $paramsToValues);
        }
        private function insert($mappedProperties){
            $filteredProperties = array_filter($mappedProperties);
            $columns = [];
            $paramsNames = [];
            $paramsToValues = [];
            foreach ($filteredProperties as $columnName => $value){
                $columns[]= '`'.$columnName.'`';
                $paramName = ':'.$columnName;
                $paramsNames[] = $paramName;
                $paramsToValues[$paramName] = $value;
            } 
            $sql = 'INSERT INTO '.static::getTableName().' ('.implode(',', $columns). ') VALUES ('.implode(',', $paramsNames) . ');';
            // exit($sql);
            $db= Db::getInstance();
            $db->id = $db->getLastInsertId();
            // $this->createdAt=$this->getById($this->id)->getCreatedAt();

            $db->query($sql, $paramsToValues, static::class);
        }
        private function mapPropertiesToDbFormat() :array{
            $reflector= new \ReflectionObject($this);
            $properties = $reflector->getProperties();
            $mappedProperties = [];
            foreach ($properties as $property){
                $propertyName = $property->name;
                $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
                $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
            }
            return $mappedProperties;
        }
        
    }

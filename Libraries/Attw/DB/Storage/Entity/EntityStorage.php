<?php 
    /**
     * This program is free software: you can redistribute it and/or modify it under the 
     *  terms of the GNU General Public License as published by the Free Software Foundation, 
     *  either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
     *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
     *  See the GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along with this program. 
     * If not, see http://www.gnu.org/licenses/gpl-3.0.html
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since AttwFramework v1.0
    */
 
    namespace Attw\DB\Storage\Entity;
    
    use Attw\Attw\DB\Storage\StorageInterface;
    use Attw\DB\Storage\SqlStorageInterface;
    use Attw\Entity\AbstractEntity;
    use \PDO;
    use \RuntimeException;
    
    /**
     * This program is free software: you can redistribute it and/or modify it under the 
     *  terms of the GNU General Public License as published by the Free Software Foundation, 
     *  either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
     *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
     *  See the GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along with this program. 
     * If not, see http://www.gnu.org/licenses/gpl-3.0.html
    */

    /**
     * @package FCodePHP
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since FCodePHP v1.0
    */
    
    /**
     * Storage to entities
    */
    class EntityStorage{
        /**
         * SQL Storage
         *
         * @var instanceof DB\Storage\iSqlStorage
         */
        private $storage;
        
        /**
         * Constructor of entity storage
         *
         * @param instanceof Attw\DB\Storage\SqlStorageInterface $storage
        */
        public function __construct( SqlStorageInterface $storage ){
            $this->storage = $storage;
        }
        
        /**
         * Insert a entity
         *
         * @param instanceof Attw\Entity\AbstractEntity $entity
        */
        public function insert( AbstractEntity $entity ){
            $table = $entity->getTable();
            $columns = $entity->getColumns();

            $this->stmt = $this->storage->insert( $table, $columns );
            $this->stmt->execute();
        }
        
        /**
         * Read
         *
         * @param instanceof Attw\Entity\AbstractEntity $entity
        */
        public function select( AbstractEntity $entity ){
            $table = $entity->getTable();
            $columns = $entity->getColumns();
            
            foreach( $columns as $column => $value ){
                if( is_null( $value ) ){
                    unset( $columns[ $column ] );
                }else{
                    $columns[ $column ] = '"' . $value . '"';
                }
            }
            
            $this->stmt = $this->storage->select( $table );

            $this->stmt->where( $columns );
            $this->stmt->setFetchMode( PDO::FETCH_CLASS, get_class( $entity ), array() );
            $this->stmt->execute();

            return $this->stmt->fetch();
        }

        /**
         * Update a registry
         *
         * @param instanceof Attw\Entity\AbstractEntity
        */
        public function update( AbstractEntity $entity ){
            $primaryKey = $entity->getPrimaryKey();

            foreach( $primaryKey as $key => $value ){
                if( is_null( $value ) || $value == '' || $value == ' ' ){
                    throw new RuntimeException( sprintf( 'The primary key "%s" must not be null', $key ) );
                }
            }

            $primaryKeyColumn = array_keys( $primaryKey );
            $primaryKeyColumn = $primaryKeyColumn[0];
            
            $table = $entity->getTable();
            $columns = $entity->getColumns();

            foreach( $columns as $column => $value ){
                if( is_null( $value ) || $column === $primaryKeyColumn ){
                    unset( $columns[ $column ] );
                }
            }

            $this->stmt = $this->storage->update( $table, $columns, $primaryKey );
            $this->stmt->execute();
        }
    }
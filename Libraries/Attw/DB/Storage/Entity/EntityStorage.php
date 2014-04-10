<?php  
    /**
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     * 
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     * 
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license https://github.com/AttwFramework/AttwFramework/blob/master/LICENSE.md
     * @since AttwFramework v1.0
    */
 
    namespace Attw\DB\Storage\Entity;
    
    use Attw\Attw\DB\Storage\StorageInterface;
    use Attw\DB\Storage\SqlStorageInterface;
    use Attw\Model\Entity\AbstractEntity;
    use \PDO;
    use \RuntimeException;
    
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
            return $this->stmt;
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
                    $columnsWhere[ $column ] = $value;
                }
            }
           
            $this->stmt = $this->storage->select( $table );
            $this->stmt->where( $columnsWhere );
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
            return $this->stmt;
        }

        /**
         * Delete a registry
         *
         * @param instanceof Attw\Entity\AbstractEntity $entity
        */
        public function delete( AbstractEntity $entity ){
            $table = $entity->getTable();
            $columns = $entity->getColumns();

            foreach( $columns as $column => $value ){
                if( is_null( $value ) ){
                    unset( $columns[ $column ] );
                }
            }

            $this->stmt = $this->storage->delete( $table, $columns );
            return $this->stmt;
        }

        /**
         * Execute a prepared statement
         *
         * @return \PDOStatement::execute()
        */
        public function execute(){
            return $this->stmt->execute();
        }

        /**
         * Return number of results
        */
        public function count(){
            return $this->stmt->count();
        }
    }

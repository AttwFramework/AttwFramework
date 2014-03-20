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
    
    namespace Attw\DB\Storage;
    
    use Attw\DB\Storage\SqlStorageInterface;
    use \PDO;
    use Attw\DB\SQL\SqlGenerator;
    use Attw\Util\SQLDrivers;
    use Attw\DB\Storage\PDO\Select;
    use Attw\DB\Storage\PDO\Insert;
    use Attw\DB\Storage\PDO\Update;
    use Attw\DB\Storage\PDO\Delete;
    use Attw\Config\Configs;
    
    /**
     * Storage with PDO
     *
     * @package FCodePHP.DB
    */
    class PDOStorage implements SqlStorageInterface{
        const FETCH_CLASS = PDO::FETCH_CLASS;
        const FETCH_OBJ = PDO::FETCH_OBJ;
        const FETCH_ASSOC = PDO::FETCH_ASSOC;
        const FETCH_COLUMN = PDO::FETCH_COLUMN;

        /**
         * Instance of \PDO
         *
         * @var instanceof \PDO
        */
        private $pdo;

        /**
         * Instance of some SQL Generator
         *
         * @var insatcneof Attw\DB\SQL\SQLGenerator
        */
        private $sqlGenerator;

        /**
         * Prepared starement
         *
         * @var mixed \PDOStatement::prepare()
        */
        private $stmt;
        
        /**
         * Constructor of PDO Storage
         *
         * @param instanceof \PDO $pdo
         * @param string current drive to use
        */
        public function __construct( PDO $pdo, $driver ){
            $this->pdo = $pdo;

            if( !Configs::exists( 'SQLGenerators' ) ){
                throw new RuntimeException( 'SQL Generators are not defineds' );
            }

            $sqlGenerators = Configs::get( 'SQLGenerators' );

            $this->sqlGenerator = $sqlGenerators[ strtolower( $driver ) ];
        }
        
        /**
         * Insert statement with PDO
         *
         * @param string $storageLocal also met as table
         * @param array $data data to insert
         * @return instanceof Attw\DB\Storage\PDO\Insert
        */
        public function insert( $storageLocal, array $data ){
            $stmt = new Insert( $this->pdo, $this->sqlGenerator, $storageLocal, $data );
            return $stmt;
        }
        
        /**
         * Select statement with PDO
         *
         * @param string $storageLocal also met as table
         * @param string | array $data data to fetch
         * @return instanceof Attw\DB\Storage\PDO\Select
        */
        public function select( $storageLocal, $data = '*' ){
            $stmt = new Select( $this->pdo, $this->sqlGenerator, $storageLocal, $data );
            return $stmt;
        }
        
        /**
         * Update statement with PDO
         *
         * @param string $storageLocal also met as table
         * @param string | array $data data to update
         * @param array $where
         * @return instanceof Attw\DB\Storage\PDO\Update
        */
        public function update( $storageLocal, array $data, array $where ){
            $stmt = new Update( $this->pdo, $this->sqlGenerator, $storageLocal, $data, $where );
            return $stmt;
        }
        
        /**
         * Delete statement with PDO
         *
         * @param string $storageLocal also met as table
         * @param array $where
         * @return instanceof Attw\DB\Storage\PDO\Delete
        */
        public function delete( $storageLocal, array $where ){
            $stmt = new Delete( $this->pdo, $this->sqlGenerator, $storageLocal, $where );
            return $stmt;
        }
        
        /**
         * Create a query with PDO
         * 
         * @param string $sql SQL to query
         * @return mixed \PDO::query()
        */
        public function query( $sql ){
            return $this->stmt = $this->pdo->query( $sql );
        }
        
        /**
         * Create a prepared statement to execute
         *
         * @param string $sql SQL to preapre
        */
        public function prepare( $sql ){
            $this->stmt = $this->pdo->prepare( $sql );
        }
        
        /**
         * Execute a prepared statement
         *
         * @param array $bindParams params to \PDOStatement::execute()
        */
        public function execute( array $bindParams = array() ){
            return $this->stmt->execute( $bindParams );
        }
        
        /**
         * Fetch all results of query/statement
         *
         * @param mixed $type Type of fetch
         * @return mixed \PDOStatement::fetchAll()
        */
        public function fetchAll( $type = null ){
            if( is_null( $type ) ){
                $type = PDO::FETCH_OBJ;
            }

            return $this->stmt->fetchAll( $type );
        }
        
        /**
         * Fetch result of query/statement
         *
         * @param mixed $type Type of fetch
         * @return mixed \PDOStatement::fetch()
        */
        public function fetchOne( $type = null ){
            if( is_null( $type ) ){
                $type = PDO::FETCH_OBJ;
            }

            return $this->stmt->fetch( $type );
        }
        
        /**
         * Set fetch mode
         *
         * @param mixed $type type of fetch mode
         * @param mixed $param first param of \PDO::setFetchMode()
         * @param mixed $param2 second param of \PDO::setFetchMode()
         * @throws \LogicException case param $param2 is not null
         *  and param $param1 is null
        */
        public function setFetchMode( $type, $param = null, $param2 = null ){
            if( $param === null && $param2 === null ){
                $this->stmt->setFetchMode( $type );
            }elseif( $param2 === null ){
                $this->stmt->setFetchMode( $type, $param );
            }elseif( $param2 !== null ){
                $this->stmt->setFetchMode( $type, $param, $param2 );
            }
        }

        /**
         * Return last inserted id
         *
         * @return integer \PDO::lastInsertId()
        */
        public function lastInsertId(){
            return $this->pdo->lastInsertId();
        }
    }
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
 
    namespace Attw\DB\Storage\PDO;
    
    use \PDO;
    use Attw\DB\SQL\SQLGenerator;
    
    /**
     * Select statement with PDO
    */
    class Select extends AbstractPDOStatement{
        const ORDERBY_DESC = 'DESC';
        const ORDERBY_ASC = 'ASC';

        /**
         * Consturctor of Select statement
         *
         * @param instanceof \PDO $pdo
         * @param instanceof Attw\DB\SQL\SQLGenerator $sql
         * @param string $from
         * @param array | string $data Columns to return
        */
        public function __construct( PDO $pdo, SQLGenerator $sql, $from, $data = '*' ){
            $this->pdo = $pdo;
            $this->sql = $sql->select( $from, $data );
            $this->stmt = $this->pdo->prepare( $this->sql );
        }
        
        /**
         * Where clause
         *
         * @param array $where
        */
        public function where( array $where ){
            foreach( $where as $column => $value ){
                $arrColumnsWhere[ $column ] = '?';
            }

            $this->sql = $this->sql->where( $arrColumnsWhere );
            $this->executeBindParams = array_values( $where );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        /**
         * Join clause
         * Inner Join | Left Join | Right Join
         *
         * @param string $table
         * @param array $params
         * @param string $type May be INNER, LEFT or RIGHT
        */
        public function join( $table, array $params, $type = 'INNER' ){
            $this->sql = $this->sql->join( $table, $params, $type );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        /**
         * Group By clause
         *
         * @param string $column
         * @return self instance
        */
        public function groupBy( $column ){
            $this->sql = $this->sql->groupBy( $column );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        /**
         * Order By clause
         *
         * @param string $column
         * @param string $type May be DB\Storage\PDO\Select::ASC or DB\Storage\PDO\Select::DESC
        */
        public function orderBy( $column, $type = '' ){
            $this->sql = $this->sql->orderBy( $column, $type );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        public function offset( $offset ){
            $this->sql = $this->sql->offset( $offset );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        public function limit( $offset, $limit ){
            $this->sql = $this->sql->limit( $offset, $limit );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            return $this;
        }
        
        public function fetch( $type = null ){
            if( is_null( $type ) ){
                $type = PDO::FETCH_OBJ;
            }

            return $this->stmt->fetch( $type );
        }
        
        public function fetchAll( $type = null ){
            if( is_null( $type ) ){
                $type = PDO::FETCH_OBJ;
            }

            return $this->stmt->fetchAll( $type );
        }

        public function setFetchMode( $type, $param = null, $param2 = null ){
            if( $param === null && $param2 === null ){
                $this->stmt->setFetchMode( $type );
            }elseif( $param2 === null ){
                $this->stmt->setFetchMode( $type, $param );
            }elseif( $param2 !== null ){
                $this->stmt->setFetchMode( $type, $param, $param2 );
            }
        }
    }
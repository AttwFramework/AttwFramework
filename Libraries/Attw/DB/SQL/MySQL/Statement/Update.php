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
 
    namespace Attw\DB\SQL\MySQL\Statement;

    use Attw\DB\SQL\AbstractStatement;
    use Attw\DB\SQL\MySQL\Clause\Set;
    use Attw\DB\SQL\MySQL\Clause\Where;
    use Attw\DB\SQL\MySQL\Operator\Equal;
    use Attw\DB\SQL\MySQL\Operator\AndO;
    use \InvalidArgumentException;
    
    /**
     * MySQL SQL Update statement
     *
     * @package FCodePHP.DB
    */
    class Update extends AbstractStatement{
        /**
         * Table to update some registries
         *
         * @param string
        */
        private $table;
        private $set;
        private $where;
        
        /**
         * Constructor to update statement
         *
         * @param string $table
         * @param array $data data to update
         * @param string | array $where
        */
        public function __construct( $table, array $data, $where ){
            if( !is_string( $table ) ){
                throw new InvalidArgumentException( get_class( $this ) . '::__construct(): the table must be a string' );
            }
            
            $this->table = $table;
            $this->constructWhere( $where );
            $this->constructSet( $data );
        }
        
        /**
         * Construct the set clause
         *
         * @param array $data data to update
        */
        private function constructSet( array $data ){
            foreach( $data as $column => $value ){
                $equals[] = new Equal( $column, $value );
            }

            $this->set = new Set( new AndO( $equals ) );
        }

        /**
         * Construct the where clause
         *
         * @param string | array $where
        */
        private function constructWhere( $where ){
            if( is_array( $where ) ){
                foreach( $where as $column => $value ){
                    $equals[] = new Equal( $column, $value );
                }

                $this->where = new Where( new AndO( $equals ) );
            }else{
                $this->where = new Where( $where );
            }
        }
        
        /**
         * Construct the update SQL
        */
        public function constructSql(){
            $this->sql = sprintf( 'UPDATE %s %s %s', 
                            $this->table, 
                            $this->set, 
                            $this->where );
        }
    }
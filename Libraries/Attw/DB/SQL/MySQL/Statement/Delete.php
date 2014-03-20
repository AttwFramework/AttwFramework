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
    use Attw\DB\SQL\MySQL\Clause\Where;
    use Attw\DB\SQL\MySQL\Operator\Equal;
    use Attw\DB\SQL\MySQL\Operator\AndO;
    use Attw\DB\SQL\MySQL\Clause\From;
    
    /**
     * MySQL SQL Delete statement
     *
     * @package FCodePHP.DB
    */
    class Delete extends AbstractStatement{
        /**
         * Table to delete some registries
         *
         * @var string
        */
        private $table;

        /**
         * Where clause to indicate some registry
         *
         * @var instanceof DB\SQL\MySQL\Clause\Where
        */
        private $where;
        
        /**
         * Contruct a delete statement
         * 
         * @param $table string
         * @param $where can be array or a string
         * @param $operator Operator to separate $where (Default: AND)
         * @throws \InvliadArgumentException case $table is not a string
         * @throws \InvliadArgumentException case $operator is diferent of AND and OR
        */
        public function __construct( $table, $where ){
            if( !is_string( $table ) ){
                throw new \InvalidArgumentException( sprintf( '%s::%s: the table must be a string', get_class( $this ), __METHOD__ ) );
            }

            
            $this->table = new From( $table );

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
         * Construct the delete SQL
        */
        protected function constructSql(){
            $this->sql = sprintf( 'DELETE %s %s', 
                            $this->table,
                            $this->where );echo $this->sql;
        }
    }
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
    use Attw\DB\SQL\MySQL\Clause\Values;
    use Attw\DB\SQL\MySQL\Operator\SimpleQuote;
    use \InvalidArgumentException;
    
    /**
     * MySQL SQL Insert statement
     *
     * @package FCodePHP.DB
    */
    class Insert extends AbstractStatement{
        /**
         * Table to do the insert
         *
         * @var string
        */
        private $table;

        /**
         * Columns to insert
         *
         * @var string
        */
        private $columns;

        /**
         * Values to insert
         *
         * @var string generated with DB\SQL\MySQL\Clause\Values
        */
        private $values;
        
        /**
         * Constructor for insert statement
         *
         * @param string $table
         * @param array $data data to inset
         * @param boolean $valuesWithQuote if is to prepared statements, false
         * @throws \InvalidArgumentException case param $table is not a string
        */
        public function __construct( $table, array $data, $valuesWithQutoes = true ){
            if( !is_string( $table ) ){
                throw new InvalidArgumentException( get_class( $this ) . '::__construct(): the table must be a string' );
            }
            
            $values = array_values( $data );
            $columns = array_keys( $data );

            $this->table = $table;
            
            $this->columns = '(`' . implode( '`, `', array_keys( $data ) ) . '`)';
            
            if( $valuesWithQutoes ){
                foreach( $values as $value ){
                    $valuesToSql[] = new SimpleQuote( $value );
                }

                $this->values = new Values( $valuesToSql );
            }else{
                $this->values = new Values( $values );
            }
        }
        
        /**
         * Construct the insert SQL
        */
        protected function constructSql(){
            $this->sql = sprintf( 'INSERT INTO %s %s %s',
                            $this->table,
                            $this->columns,
                            $this->values );
        }
    }
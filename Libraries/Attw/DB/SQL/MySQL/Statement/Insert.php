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
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
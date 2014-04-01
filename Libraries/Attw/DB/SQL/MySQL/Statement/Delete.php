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
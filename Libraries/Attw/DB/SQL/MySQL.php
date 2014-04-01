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
 
    namespace Attw\DB\SQL;

    use Attw\DB\SQL\SQLGenerator;
    use Attw\DB\SQL\MySQL\Statement\Select;
    use Attw\DB\SQL\MySQL\Statement\Insert;
    use Attw\DB\SQL\MySQL\Statement\Update;
    use Attw\DB\SQL\MySQL\Statement\Delete;
    
    /**
     * Adapter to MySQL SQL
     * 
     * E.g.:
     * $mysql = new MySQL;
     * $select = $mysql->select( 'table' );
     * $select->where( array( 'id' => 17 ) );
    */
    class MySQL implements SQLGenerator{
        /**
         * Create a select statement
         *
         * @return instanceof DB\SQL\MySQL\Statement\Select
        */
        public function select( $container, $columns = '*' ){
            return new Select( $columns, $container );
        }
        
        /**
         * Create a insert statement
         *
         * @return instanceof DB\SQL\MySQL\Statement\Insert
        */
        public function insert( $container, array $data, $columnsWithQutoes = true ){
            return new Insert( $container, $data, $columnsWithQutoes );
        }
        
        /**
         * Create a update statement
         *
         * @return instanceof DB\SQL\MySQL\Statement\Update
        */
        public function update( $container, array $data, $where ){
            return new Update( $container, $data, $where );
        }
        
        /**
         * Create a delete statement
         *
         * @return instanceof DB\SQL\MySQL\Statement\Delete
        */
        public function delete( $container, $where ){
            return new Delete( $container, $where );
        }
    }
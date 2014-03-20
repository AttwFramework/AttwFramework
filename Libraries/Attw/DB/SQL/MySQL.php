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
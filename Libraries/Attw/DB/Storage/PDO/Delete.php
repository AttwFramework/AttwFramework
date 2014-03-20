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
     * Delete statement with PDO
     *
     * @package FCodePHP.DB
    */
    class Delete extends AbstractPDOStatement{
        /**
         * Constructor to delete
         *
         * @param instanceof \PDO $pdo
         * @param instanceof Attw\DB\SQL\SQLGenerator $sql
         * @param string $container also met as table
         * @param array $where
        */
        public function __construct( PDO $pdo, SQLGenerator $sql, $container, array $where ){
            $this->pdo = $pdo;

            foreach( $where as $column => $value ){
                $arrColumnsWhere[ $column ] = '?';
            }

            $this->sql = $sql->delete( $container, $arrColumnsWhere );
            $this->stmt = $this->pdo->prepare( $this->sql );
            $this->executeBindParams = array_values( $where );
        }
    }
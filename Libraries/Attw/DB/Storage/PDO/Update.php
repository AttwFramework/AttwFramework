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
     * Update statement with PDO
     *
     * @package FCodePHP.DB
    */
    class Update extends AbstractPDOStatement{
        /**
         * Constructor to udate statement
         *
         * @param instanceof \PDO $pdo
         * @param instanceof Attw\DB\SQL\SQLGenerator $sql
         * @param string $container also met as table
         * @param array $data data to update
         * @param array $where
        */
        public function __construct( PDO $pdo, SQLGenerator $sql, $container, array $data, array $where ){
            $this->pdo = $pdo;

            foreach( $data as $column => $value ){
                $arrColumns[ $column ] = '?';
            }

            foreach( $where as $column => $value ){
                $arrColumnsWhere[ $column ] = '?';
            }

            $this->sql = $sql->update( $container, $arrColumns, $arrColumnsWhere );
            $this->stmt = $this->pdo->prepare( $this->sql );
            
            $this->executeBindParams = array_merge( array_values( $data ), array_values( $where ) );
        }
    }
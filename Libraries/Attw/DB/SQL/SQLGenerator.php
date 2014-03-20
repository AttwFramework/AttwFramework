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

    /**
	 * Interface to diferents SQL Generators
	 * (MySQL, MsSQL, PostgreSQL etc.)
    */
    interface SQLGenerator{
        /**
         * Generate a SQL to select
         *
         * @param string $container also met as table
         * @param string | array $columns columns to fetch
        */
        public function select( $container, $columns = '*' );

        /**
         * Generate a SQL to insert
         *
         * @param string $container also met as table
         * @param array $data data to insert
        */
        public function insert( $container, array $data );

        /**
         * Generate a SQL to update
         *
         * @param string $container also met as table
         * @param array $data data to set
         * @param string | array $where
        */
        public function update( $container, array $data, $where );

        /**
         * Generate a SQL to delete
         *
         * @param string $container also met as table
         * @param string | array $where
        */
        public function delete( $container, $where );
    }
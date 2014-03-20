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
 
    namespace Attw\DB\Storage;
    
    use Attw\DB\Storage\TransactionsInterface;

    /**
	 * Interface to storages
	 *
	 * @package FCodePHP.DB
    */
    interface StorageInterface extends TransactionsInterface{
    	/**
		 * To insert something
		 *
		 * @param string $storageLocal local to inert
		 * @param array $data data to insert
    	*/
        public function insert( $storageLocal, array $data );

        /**
		 * To delete something
		 *
		 * @param string $storageLocal local to delete
		 * @param array $where
        */
        public function delete( $storageLocal, array $where );

        /**
		 * To update something
		 *
		 * @param string $storageLocal local to update
		 * @param array $data data to set
		 * @param array $where
        */
        public function update( $storageLocal, array $data, array $where );

        /**
		 * To fetch something
		 *
		 * @param string $storageLocal local to update
		 * @param string | array data to fetch
        */
        public function select( $storageLocal, $data = '*' );
    }
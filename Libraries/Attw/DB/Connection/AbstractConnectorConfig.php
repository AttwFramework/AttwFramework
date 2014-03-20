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
 
    namespace Attw\DB\Connection;

    /**
     * Interface to connectors cofigurations
     *
     * @package FCodePHP.DB
    */
    abstract class AbstractConnectorConfig{
        /**
         * Username to host connection
         *
         * @var string
        */
        protected $user;

        /**
         * Password to host connection
         *
         * @var string
        */
        protected $password;

        /**
         * Database to host connection
         *
         * @var string
        */
        protected $dbname;

        /**
         * Host
         *
         * @var string
        */
        protected $host;

        /**
         * Port to connection
         *
         * @var integer
        */
        protected $port = null;
        
        /**
         * Get user to host connection
         *
         * @return string
        */
        public function getUser(){
            return $this->user;
        }
        
        /**
         * Get password to host connection
         *
         * @return string
        */
        public function getPassword(){
            return $this->password;
        }
        
        /**
         * Get the DSN to connection
         *
         * @return string
        */
        abstract public function getDsn();
    }
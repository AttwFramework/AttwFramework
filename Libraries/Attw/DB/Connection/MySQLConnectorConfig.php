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
    
    use Attw\DB\Connection\AbstractConnectorConfig;
    
    /**
     * MySQL Connector Config
    */
    class MySQLConnectorConfig extends AbstractConnectorConfig{
        /**
         * Constructor of MySQL Config
         * Set the params to connection
         *
         * @param string $host
         * @param string $dbname
         * @param string $user
         * @param string $password
         * @param integer $port
        */
        public function __construct( $host, $dbname, $user, $password, $port = null ){
            $this->host = $host;
            $this->dbname = $dbname;
            $this->port = $port;
            $this->user = $user;
            $this->password = $password;
        }
        
        /**
         * Get DSN to connector
         *
         * @return string
        */
        public function getDsn(){
            return  ( !is_null( $this->port ) ) 
                    ? sprintf( 'mysql:host=%s;dbname=%s;port=%s', $this->host, $this->dbname, $this->port ) 
                    : sprintf( 'mysql:host=%s;dbname=%s', $this->host, $this->dbname );
        }
    }
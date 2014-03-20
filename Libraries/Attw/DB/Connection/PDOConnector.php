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
    use \PDO;
    
    class PDOConnector implements iConnector{
        /**
         * Configurations to connection
         *
         * @var instanceof Attw\DB\Connection\AbstractConnectorConfig
        */
        private $config;
        
        /**
         * Instance of \PDO
         *
         * @var instanceof \PDO
         */
        private $instance;
        
        public function __construct( AbstractConnectorConfig $config ){
            $this->config = $config;
            $this->connect();
        }
        
        public function connect(){
            if( !$this->isConnected() ){
                $this->instance = new PDO(
                    $this->config->getDsn(),
                    $this->config->getUser(),
                    $this->config->getPassword()
                );
                
                $this->instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
        }
        
        public function disconnect(){
            $this->instance = null;
        }
        
        public function getConnection(){
            return $this->instance;
        }
        
        public function isConnected(){
            return ( $this->instance instanceof PDO );
        }
        
        public function getDriver(){
            return $this->instance->getAttribute( PDO::ATTR_DRIVER_NAME );
        }
    }
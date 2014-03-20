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
 
    namespace Attw\DB;
    
    use Attw\DB\Connection\iConnector;
    use \RuntimeException;
    use \ArrayObject;

    /**
     * A collection with database connections to the application
     *
     * @example
     *  To add a connection:
     *  Collection::add( 'Conn1', new PDOConnector( $connector_configs ) );
    */
    class Collection{
        /**
         * Collection with user database connections
         *
         * @var instanceof \ArrayObject 
        */
        private static $connections;      
        
        /**
         * Attach a connector to colletion
         *
         * @param string $key identification to connection
         * @param instanceof Attw\DB\Connection\iConnector $connector
         * @throws \RuntimeException case param $key already exists
        */
        public static function add( $key, iConnector $connector ){
            self::connectionsToObject();

            if( self::$connections->offsetExists( $key ) ){
                throw new RuntimeException( 'This connection have already added: ' . print_r( $key, true ) );
            }
            
            self::$connections->offsetSet( $key, $connector );
        }
        
        /**
         * Remove a connection from colletion
         * 
         * @param string $key identification to connection
         * @throws \RuntimeException case param $key do not exists
        */
        public static function remove( $key ){
            self::connectionsToObject();

            if( !self::$connections->offsetExists( $key ) ){
                throw new RuntimeException( 'This connection doesn\'t exists: ' . print_r( $key, true ) );
            }
            
            self::$connections->offsetUnset( $key );
        }
        
        /**
         * Get a connection from collection by identification key
         *
         * @param string $key identification to connection
         * @return implementation of DB\Connection\iConnector
         * @throws \RuntimeException case param $key do not exists
         * @return instanceof Attw\DB\Connection\iConnector
        */
        public static function get( $key ){
            self::connectionsToObject();

            if( !self::$connections->offsetExists( $key ) ){
                throw new RuntimeException( 'This connection doesn\'t exists: ' . print_r( $key, true ) );
            }
            
            return self::$connections->offsetGet( $key );
        }
        
        /**
         * Verify a identification key exists in the collection
         *
         * @param string $key identification to connection
         * @return boolean 'true' case exists and 'false' case does not
        */
        public static function exists( $key ){
            self::connectionsToObject();

            return self::$connections->offsetExists( $key );
        }

        private static function connectionsToObject(){
            if( !( self::$connections instanceof ArrayObject ) ){
                self::$connections = new ArrayObject();
            }
        }
    }
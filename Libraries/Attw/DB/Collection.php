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
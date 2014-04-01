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
 
    namespace Attw\Config;

    use \ArrayObject;
    use \InvalidArgumentException;
    use \RuntimeException;

    /**
     * Configuration collention of application
    */
    class Configs{
        /**
         * Collection with configs
         *
         * @param instanceof \ArrayObject
        */
        private static $configs;
        
        /**
         * Attach a configuration to colletion
         *
         * @param string $key Indentification key
         * @param mixed $config
         * @throws \InvalidArgumentException case param $key is not a string
         * @throws \RuntimeException case identification key has been already added
        */
        public static function add( $key, $config ){
            self::configToObject();

            if( !is_string( $key ) ){
                throw new InvalidArgumentException( 'Key must be a string' );
            }

            if( self::$configs->offsetExists( $key ) ){
                throw new RuntimeException( 'This key have already added: ' . $key );
            }
            
            self::$configs->offsetSet( $key, $config );
        }
        
        /**
         * Dettach a configuration of collection
         *
         * @param string $key Identification key
         * @throws \RuntimeException case doesn't exists a config with the key $key
        */
        public static function remove( $key ){
            self::configToObject();

            if( !self::$configs->offsetExists( $key ) ){
                throw new RuntimeException( 'This key doesn\'t exists: ' . $key );
            }
            
            self::$configs->offsetUnset( $key );
        }
        
        /**
         * Get a configuration of collection
         *
         * @param string $key Identification key
         * @throws \RuntimeException case doesn't exists a config with the key $key
        */
        public static function get( $key ){
            self::configToObject();

            if( !self::$configs->offsetExists( $key ) ){
                throw new RuntimeException( 'This key doesn\'t exists: ' . $key );
            }
            
            return self::$configs->offsetGet( $key );
        }
        
        /**
         * Verify if exists a configuration in collection
         *
         * @param string $key Identification key
         * @return boolean
        */
        public static function exists( $key ){
            self::configToObject();

            return self::$configs->offsetExists( $key );
        }

        /**
         * Create a instance of \ArrayObject 
         *  case doesn't exists
        */
        private static function configToObject(){
            if( !( self::$configs instanceof ArrayObject ) ){
                self::$configs = new ArrayObject();
            }
        }
    }
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
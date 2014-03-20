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
 
    namespace Attw\Core;
    
    use \RuntimeException;
    use Attw\Logger\Log\File;
    use Attw\Application\Configs;

    abstract class Object{
    	/**
		 * Get the name of object
		 *
		 * @return string
    	*/
        public function __toString(){
            return get_class( $this );
        }

        /**
		 * Call a method of this object
		 *
         * @param string $method Method to call
         * @param array $params Params to method
		 * @return mixed Return the return of method called
        */
        public function callMethod( $method, array $params = array() ){
        	if( !method_exists( $method, $this ) ){
                throw new RuntimeException( sprintf( 'Method doesn\'t exists: %s::%s()', 
                                                     get_class( $this ), 
                                                     ( string ) $method ) );
            }

            return call_user_func_array( array( $this, $method ), $params );
        }

        /**
         * Write a log
         * The log will be save on file defined in Configs
         *
         * @param string $message Message to log
         * @param string | integer $type Log type
         * @throws \RuntimeException case logs is not actived
         * @return mixed Return of Logger\Log\File::write()
        */
        public function writeLog( $message, $type = LOG_ERR ){
            return File::write( $type, print_r( $message, true ) );
        }
    }
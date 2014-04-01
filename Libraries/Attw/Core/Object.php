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
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
 
    namespace Attw\HTTP\Cookie;

    use \UnexpectedValueException;
    
    class Cookies{
        public function add( $name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false ){
            $this->cookies->attach( func_get_args() );
            
            setcookie( $nome, $value, $expire, $path, $domain, $secure, $httponly );
        }
        
        public function read( $name ){
            if( !$this->exists( $name ) ){
                throw new UnexpectedValueException( sprintf( 'Cookie named %s doesn\'t exists', $name ) );
            }
            
            return $_COOKIE[ $name ];
        }
        
        public function del( $name ){
            if( !$this->exists( $name ) ){
                throw new UnexpectedValueException( sprintf( 'Cookie named %s doesn\'t exists', $name ) );
            }
            
            setcookie( $name, null, time() - 3600 );
        }
        
        public function delAll(){
            foreach( $_COOKIE as $name => $value ){
                $this->del( $name );
            }
        }
        
        public function exists( $name ){
            return ( array_key_exists( $_COOKIE, $name ) );
        }
    }
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
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
 
    namespace Attw\Session;
    
    use \SessionHandlerInterface;
    use \SplFileObject;
    
    class Handler implements SessionHandlerInterface{
        private $sessionPath;
        
        public function open( $save_path, $name ){
            if( !is_dir( $save_path ) ){
                mkdir( $save_path, 0777 );
            }
            
            $this->sessionPath = $save_path;
            
            return true;
        }
        
        public function close(){
            return true;
        }
        
        public function read( $session_id ){
            $fileDir = $this->sessionPath . '/sess_' . $session_id;
            
            $fileIterator = new SplFileObject( $fileDir );
            $string = '';
            
            while( !$fileIterator->eof() ){
                $string .= $fileIterator->fgets();    
            }
            
            return ( string ) $string;
        }
        
        public function write( $session_id, $session_data ){
            $fileDir = $this->sessionPath . '/sess_' . $session_id;
            
            $fileIterator = new SplFileObject( $fileDir );
            return ( $fileIterator->fwrite( $session_data ) === false ) ? false : true;
        }
        
        public function destroy( $session_id ){
            $fileDir = $this->sessionPath . '/sess_' . $session_id;
            
            if( file_exists( $fileDir ) ){
                return unlink( $fileDir );
            }
        }
        
        public function gc( $maxlifetime ){
            $fileDir = $this->sessionPath . 'sess_*';
            
            foreach( glob( $fileDir ) as $file ){
                if ( filemtime( $file ) + $maxlifetime < time() && file_exists( $file ) ){
                    return unlink( $file );
                }
            }
        }
    }
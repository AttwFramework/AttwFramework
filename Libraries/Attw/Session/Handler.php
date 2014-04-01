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
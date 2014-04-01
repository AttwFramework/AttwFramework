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

    /**
     * For autoload classes
    */
    class Autoloader{
        /**
         * Collecion with autoloadiables
         *
         * @var instanceof \SplObjectStorage
        */
        private $autoloadables;
        
        public function __construct(){
            $this->autoloadables = new \SplObjectStorage();
        }
        
        /**
         * Attach a autoloadiable
         *
         * @param instanceof iAutoLoadble
        */
        public function attach( iAutoloadable $autoloadable ){
            if( $this->autoloadables->contains( $autoloadable ) ){
                throw new \Exception( 'The autoload has been duplicated' );
            }
            
            $this->autoloadables->attach( $autoloadable );
            
            spl_autoload_register( $autoloadable->getCallable() );
        }
        
        /**
         * Detach a autoloadiable
         *
         * @param instanceof iAutoLoadble
        */
        public function detach( iAutoloadable $autoloadable ){
            if( !$this->autoloadables->contains( $autoloadable ) ){
                throw new \Exception( 'The autoload hasn\'t been duplicated' );
            }
            
            $this->autoloadables->detach( $autoloadable );
            
            spl_autoload_unregister( $autoloadable->getCallable() );
        }
        
        /**
         * Get all autoloadiables
        */
        public function getAll(){
            return $this->autoloadables;
        }
    }
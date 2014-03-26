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
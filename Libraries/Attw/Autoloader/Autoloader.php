<?php
    namespace Autoloader;

    class Autoload{
        private $autoloadables;
        
        public function __construct(){
            $this->autoloadables = new \SplObjectStorage();
        }
        
        public function attach( iAutoloadable $autoloadable ){
            if( $this->autoloadables->contains() ){
                throw new \Exception( 'The autoload has been duplicated' );
            }
            
            $this->autoloadables->attach( $autoloadable );
            
            spl_autoload_register( $autoloadable->getCallable() );
        }
        
        public function detach( iAutoloadable $autoloadable ){
            if( !$this->autoloadables->contains() ){
                throw new \Exception( 'The autoload hasn\'t been duplicated' );
            }
            
            $this->autoloadables->detach( $autoloadable );
            
            spl_autoload_unregister( $autoloadable->getCallable() );
        }
        
        public function getAll(){
            return $this->autoloadables;
        }
    }
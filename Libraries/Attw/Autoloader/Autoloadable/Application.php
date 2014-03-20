<?php
    namespace Autoloader\Autoloadable;
    
    use Autoloader\Autoloadable\iAutuloadable;
    use Application\Config;
    
    class Application implements iAutloadable{
        private $applicationPath;
        
        public function __construct(){
            $configs = Configs::getInstance();
            
            if( !$configs->exists( 'Paths' ) ){
                throw new \Exception( 'Define an array with project paths' );
            }
            
            $paths = $config->get( 'Paths' );
            
            if( !isset( $paths['Application'] ) ){
                throw new \Exception( 'Define a path for your application' );
            }
            
            $this->applicationPath = $paths['Application'];
        }
        
        public function getCallable(){
            return function( $class ){
                $file = $this->applicationPath . DS . $class . '.php';
                
                if( !file_exists( $file ) ){
                    throw new \Exception( 'Class not found: ' . $class );
                }
                
                require_once $file;
            };
        }
    }
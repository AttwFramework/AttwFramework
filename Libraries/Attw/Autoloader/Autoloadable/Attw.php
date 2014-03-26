<?php
    class Attw implements iAutoloadable{
        private $applicationPath;
        
        public function __construct( $path ){
            $this->applicationPath = $path;
        }
        
        public function getCallable(){
            return function( $class ){
                $fileApp = $this->applicationPath . DS . $class . '.php';
                
                if( file_exists( $fileApp ) ){
                    require_once $fileApp;
                }
            };
        }
    }
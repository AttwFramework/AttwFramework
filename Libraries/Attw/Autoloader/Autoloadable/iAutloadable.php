<?php
    namespace Autoloader\Autoloadable;
    
    interface iAutloadable{
        /**
         * @return callable
         */
        public function getCallable();
    }
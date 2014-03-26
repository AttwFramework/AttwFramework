<?php
    interface iAutoloadable{
        /**
         * @return callable
         */
        public function getCallable();
    }
<?php
    define( 'DS', DIRECTORY_SEPARATOR );
    define( 'APP_ROOT', realpath( __DIR__  . '..' . DS . '..' . DS ) );
    define( 'SRC', APP_ROOT . DS . 'src' );
    define( 'LIBS', APP_ROOT . DS . 'Libraries' );
    define( 'CORE', LIBS );
    define( 'APP', APP_ROOT . DS . 'Application' );
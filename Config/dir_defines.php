<?php
    define( 'DS', DIRECTORY_SEPARATOR );
    define( 'APP_ROOT', realpath( __DIR__  . '..' . DS . '..' . DS ) );
    define( 'LIBS', APP_ROOT . DS . 'Libraries' );
    define( 'APP', APP_ROOT . DS . 'Application' );

    
    define( 'PUBLIC_FILES', APP_ROOT . DS . 'public' );
    define( 'IMAGES', PUBLIC_FILES . DS . 'images' );
    define( 'CSS', PUBLIC_FILES . DS . 'css' );
    define( 'JS', PUBLIC_FILES . DS . 'js' );
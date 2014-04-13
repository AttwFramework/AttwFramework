<?php
    ( !defined( 'DS' ) ) ? define( 'DS', DIRECTORY_SEPARATOR ) : null;
    ( !defined( 'APP_ROOT' ) ) ? define( 'APP_ROOT', realpath( __DIR__  . '..' . DS . '..' . DS ) ) : null;
    ( !defined( 'LIBS' ) ) ? define( 'LIBS', APP_ROOT . DS . 'Libraries' ) : null;
    ( !defined( 'APP' ) ) ? define( 'APP', APP_ROOT . DS . 'Application' ) : null;
    ( !defined( 'ATTW' ) ) ? define( 'ATTW', LIBS . DS . 'Attw' ) : null;
    
    ( !defined( 'PUBLIC_FILES' ) ) ? define( 'PUBLIC_FILES', APP_ROOT . DS . 'public' ) : null;
    ( !defined( 'IMAGES' ) ) ? define( 'IMAGES', PUBLIC_FILES . DS . 'images' ) : null;
    ( !defined( 'CSS' ) ) ? define( 'CSS', PUBLIC_FILES . DS . 'css' ) : null;
    ( !defined( 'JS' ) ) ? define( 'JS', PUBLIC_FILES . DS . 'js' ) : null;
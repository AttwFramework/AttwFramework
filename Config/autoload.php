<?php
    /*define('ROOT', dirname(__FILE__));    
    require 'AutoLoad_class.php';  
    $autoLoad = new AutoLoad();  
    $autoLoad->setPath(APP_ROOT);  
    $autoLoad->setExt('php');  
    
    $libs = array(
        'Smarty' => LIBS . DS . 'Smarty' . DS . 'libs' . DS . 'Smarty.class.php'
    );
    
    foreach( $libs as $lib => $libDir ){
        if( !file_exists( $libDir ) ){
            throw new Exception( 'Library not found: ' . $lib );
        }
        
        include_once $libDir;
    }
    
    spl_autoload_register(array($autoLoad, 'loadApp'));
    spl_autoload_register(array($autoLoad, 'loadCore'));*/

    require_once LIBS . DS . 'Attw'. DS . 'Autoloader'. DS . 'Autoloader.php';
    require_once LIBS . DS . 'Attw'. DS . 'Autoloader'. DS . 'Autoloadable'. DS . 'iAutloadable.php';
    require_once LIBS . DS . 'Attw'. DS . 'Autoloader'. DS . 'Autoloadable'. DS . 'Application.php';
    require_once LIBS . DS . 'Attw'. DS . 'Autoloader'. DS . 'Autoloadable'. DS . 'Attw.php';
   
    $libs = array(
        'Smarty' => LIBS . DS . 'Smarty' . DS . 'libs' . DS . 'Smarty.class.php'
    );
    
    foreach( $libs as $lib => $libDir ){
        if( !file_exists( $libDir ) ){
            throw new Exception( 'Library not found: ' . $lib );
        }
        
        include_once $libDir;
    }
    
    $autoloader = new Autoloader();
    $application = new Application( APP );
    $attw = new Attw( LIBS );
    $autoloader->attach( $application );
    $autoloader->attach( $attw );
<?php
    define('ROOT',dirname(__FILE__));    
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
    spl_autoload_register(array($autoLoad, 'loadCore'));
    
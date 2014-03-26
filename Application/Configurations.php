<?php
	use Attw\Config\Configs;

	/**
	 * Configurations of logs
	*/
	$logs = array(  'SystemErrorLogs' => array( 
						'Activated' => true,
						'File' => APP_ROOT . DS . 'Application' . DS . 'err-logs.txt' 
					),

				   'SystemLogs' => array( 
				   		'File' => APP_ROOT . DS . 'Application' . DS . 'logs.txt' 
				   	),

				   'LogTypesLocals' => array( 
				   		
						LOG_WARNING => APP_ROOT . DS . 'Application' . DS . 'logs' . DS . 'logs-warning.txt' 
					)
	);

	Configs::add( 'Logs', $logs );

	/**
	 * SQL Generators Collection
	*/
	$sqls = array( 'mysql' => new Attw\DB\SQL\MySQL );

	Configs::add( 'SQLGenerators', $sqls );

	/**
	 * Paths configuration
	*/
	$paths = array( 'Templates' => APP_ROOT . DS . 'Application' . DS . 'MVC' . DS . 'View' . DS . 'Templates',
                    'Temporary' => APP_ROOT . DS . 'tmp' );
    
    Configs::add( 'Paths', $paths );

    /**
	 * TimeZone
    */
    Configs::add( 'Timezone', 'America/Sao_Paulo' );

    /**
	 * Errors
    */
    Configs::add( 'ErrorsReporting', E_ALL | E_STRICT  );
	Configs::add( 'PageErrors', array( '404' => 'http://localhost' ) );

    /**
     * Content types
    */
    Configs::add( 'Content-Type', 'text/html' );
    Configs::add( 'Charset', 'UTF-8' );

    require_once 'Configurations/db_connections.php';
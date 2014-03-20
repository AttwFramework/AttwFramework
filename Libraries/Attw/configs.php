<?php
	use Attw\Config\Configs;
	use Attw\HTTP\Response;

	/**
	 * Errors
	*/
	if( Configs::exists( 'ErrorsReporting' ) ){
		error_reporting( Configs::get( 'ErrorsReporting' ) );
	}else{
		error_reporting( E_ALL | E_STRICT );
	}

	/**
	 * Timezone
	*/
	if( Configs::exists( 'Timezone' ) ){
		date_default_timezone_set( Configs::get( 'Timezone' ) );
	}

	/**
	 * Page encoding
	*/
	if( Configs::exists( 'Content-Type' ) ){
		$response = new Response;
		if( Configs::exists( 'Charset' ) ){
			$response->sendHeader( 'Content-Type', Configs::get( 'Content-Type' ) . '; Charset=' . Configs::get( 'Charset' ) );
		}else{
			$response->sendHeader( 'Content-Type', Configs::get( 'Content-Type' ) );
		}
	}
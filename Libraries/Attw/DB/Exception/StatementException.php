<?php
	namespace Attw\DB\Exception;

	use \RuntimeException;

	class StatementException extends RuntimeException{
		public function __construct( $message, $code = 0 ){
			parent::__construct( $message, $code );
		}
	}
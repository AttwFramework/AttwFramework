<?php 
    /**
     * This program is free software: you can redistribute it and/or modify it under the 
     *  terms of the GNU General Public License as published by the Free Software Foundation, 
     *  either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
     *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
     *  See the GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along with this program. 
     * If not, see http://www.gnu.org/licenses/gpl-3.0.html
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license http://www.gnu.org/licenses/gpl-3.0.html
     * @since AttwFramework v1.0
    */
 
	namespace Attw\Logger\Log;

	use Attw\Logger\AbstractLogger;
	use \RuntimeException;
	use \InvalidArgumentException;
	use Attw\Config\Configs;
	use \DateTime;
	use \DateTimeZone;

	/**
	 * File logger
	 *
	 * @package FCodePHP.Logger
	*/
	class File extends AbstractLogger{
		/**
		 * File to registry the logs
		 *
		 * @var string
		*/
		private static $file;

		/**
		 * Log to registry in file
		 *
		 * @var string
		*/
		private static $log;

		/**
		 * Replace log content to the ultimate
		 *
		 * @var boolean false to append a new log
		*/
		private static $replace = false;

		/**
		 * Set where the log will be registred
		 *
		 * @param string $file
		 *  if file doesn't exists, create empty
		 * @throws \RuntimeException case file not exists
		 * @throws \RuntimeException case file is not writeable
		*/
		public static function setFile( $file ){
			if( !file_exists( $file ) ){
				file_put_contents( $file, null );
			}

			if( !is_writable( $file ) ){
				throw new RuntimeException( 'File not writeable: ' . $file );
			}

			self::$file = ( string ) $file;
		}

		/**
		 * Choose if the new log will replace the file to it
		 *
		 * @param boolean $replace
		 * @throws \InvalidAgumentException case param $replace is not boolean
		*/
		public static function replace( $replace ){
			if( !is_bool( $replace ) ){
				throw new InvalidArgumentException( 'The first argument must be boolean' );
			}

			self::$replace = $replace;
		}

		/**
		 * Write a log in a file
		 *
		 * @param string $type
		 * @param string $message
		 * @return void
		*/
		public static function write( $type, $message ){
			self::logConstruct( $type, $message );

			if( is_null( self::$file ) ){
				if( Configs::exists( 'Logs' ) ){
					$logs = Configs::get( 'Logs' );
					$logsFileByTypes = $logs['LogTypesLocals'];

					foreach( $logsFileByTypes as $logType => $local ){
						if( $logType == $type ){
							self::setFile( $local );
						}
					}

					if( is_null( self::$file ) ){
						throw new RuntimeException( 'Define a file to save the logs or a file to save the logs' );
					}
				}
			}

			return ( !self::$replace ) ? file_put_contents( self::$file, self::$log . "\n", FILE_APPEND ) :
								   		 file_put_contents( self::$file, self::$log . "\n" );
		}

		/**
		 * Construct a log by the log structure
		 *
		 * @param string $type
		 * @param string $message
		*/
		private static function logConstruct( $type, $message ){
			$types = array_flip( self::$types );

			if( isset( $types[ $type ] ) ){
				$type = $types[ $type ];
			}

			if( Configs::exists( 'Timezone' ) ){
				$timezone = new DateTimeZone( Configs::get( 'Timezone' ) );
			}

			$date = ( isset( $timezone ) ) ? new DateTime( null, $timezone ) :
											 new DateTime();
			$date = $date->format( 'Y/m/d H:i:s' );

			$arr = array_merge( self::$customizedCamps, array( 
				':type' => ucfirst( $type ), ':date' => $date, ':message' => $message 
			) );

			self::$log = self::$logStructure;

			foreach( $arr as $camp => $value ){
				self::$log  = str_replace( $camp, $value, self::$log );
			}
		}
	}
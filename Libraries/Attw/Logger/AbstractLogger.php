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
 
	namespace Attw\Logger;

	use Attw\Logger\LoggerInterface;

	/**
	 * Interface to logger
	*/
	abstract class AbstractLogger implements LoggerInterface{
		/**
		 * Types of logs
		 *
		 * @var array
		*/
		public static $types = array( 
			'emergency' => LOG_EMERG,
			'alert' => LOG_ALERT,
			'critical' => LOG_CRIT,
			'error' => LOG_ERR,
			'warning' => LOG_WARNING,
			'notice' => LOG_NOTICE,
			'info' => LOG_INFO,
			'debug' => LOG_DEBUG
		);

		/**
		 * Customized camps of log
		 *
		 * @var array
		*/
		protected static $customizedCamps = array();

		/**
		 * Log structure
		 *
		 * @var string
		*/
		protected static $logStructure = '[:type | :date] :message';

		/**
		 * Set log structure
		 * The camps must have as first caracter ":" (without quotes)
		 *
		 * @param string $logStructure
		*/
		public static function setLogStructure( $logStructure ){
			self::$logStructure = ( string ) $logStructure;
		}

		/**
		 * Attach a customized camps on log
		 *
		 * @param array | string $camp If be array, be the association
		 *  if is string, require the second param
		 * @param string $value
		*/
		public static function addCustomizedCamp( $camp, $value = null ){
			if( is_array( $camp ) ){
				self::$customizedCamps = $camp;
			}else{
				if( is_string( $camp ) && is_null( $value ) ){
					throw new UnexpectedValueException( 'If the first param is string, the second must not be null' );
				}

				self::$customizedCamps[ $camp ] = $value;
			}
			foreach( self::$customizedCamps as $camp => $value ){
				unset( self::$customizedCamps[ $camp ] );
				if( substr( $camp, 0, 1 ) != ':' ){
					$camp = ':' . $camp;
				}

				self::$customizedCamps[ print_r( $camp, true ) ] = print_r( $value, true );
			}
		}
	}
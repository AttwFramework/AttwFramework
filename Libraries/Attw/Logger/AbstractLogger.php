<?php  
    /**
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     * 
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     * 
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license https://github.com/AttwFramework/AttwFramework/blob/master/LICENSE.md
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
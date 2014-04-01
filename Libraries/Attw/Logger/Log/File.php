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
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
 
	namespace Attw\Session;

	use \UnexpectedValueException;

	/**
	 * Session manager
	*/
	class Manager{
		/**
		 * Return if sessions is started
		 *
		 * @var boolean
		*/
		private $started = false;

		/**
		 * Start all sessions
		*/
		public function startAll(){
			if( $this->started() ){
				session_start();
				$this->started = true;
			}
		}

		/**
		 * Destroy all sessions
		*/
		public function destroyAll(){
			session_destroy();
			$this->started = false;
		}

		/**
		 * Verify if session are starteds
		 *
		 * @return boolean
		*/
		public function isStarted(){
			return isset( $_SESSION );
		}

		/**
		 * Get value of a session
		 *
		 * @param string $name Session name
		 * @throws \UnexpetedValueException case Session doesn't exists
		*/
		public function get( $name ){
			if( $this->exists( $name ) ){
				return $_SESSION[ $name ];
			}

			throw new UnexpectedValueException( sprintf( 'Session doesn\'t started: %s', $name ) );
		}

		/**
		 * Create or set a session
		 *
		 * @param string $name
		 * @param mixed $value
		*/
		public function set( $name, $value ){
			if( !$this->isStarted() ){
				$this->startAll();
			}

			$_SESSION[ $name ] = $value;
		}

		/**
		 * Veirify if a session exists
		 *
		 * @param string $name
		 * @return boolean
		*/
		public function exists( $name ){
			return isset( $_SESSION[ $name ] );
		}
	}
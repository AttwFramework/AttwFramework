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
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
 
	namespace Attw\File;

	use \UnexpectedValueException;
	use \RuntimeException;

	/**
	 * File to object
	*/
	class File{
		/**
		 * File compoenents
		 *
		 * @var array
		*/
		private $file;

		/**
		 * Set the file
		 *
		 * @param array $file File ($_FILES['file'])
		 * @throws \UnexpectedValueException case param $file is not a file
		*/
		public function __construct( array $file ){
			$this->file = $file;

			if( !isset( $file['tmp_name'] ) && !file_exists( $file['tmp_name'] ) ){
				throw new UnexpectedValueException( 'Invalid file: ' . print_r( $file, true ) );
			}
		}

		/**
		 * Set some propriety of file
		 *
		 * @param string $propriety
		 * @param mixed $value
		*/
		public function __set( $propriety, $value ){
			if( !in_array( $propriety, $this->file ) ){
				throw new RuntimeException( sprintf( '%s is not a propriety of file', print_r( $propriety, true ) ) );
			}

			$this->file[ $propriety ] = print_r( $value, true );
		}

		/**
		 * Get some proptiety of file
		 *
		 * @param string $propriety
		 * @return mixed
		*/
		public function __get( $propriety ){
			if( !in_array( $propriety, $this->file ) ){
				throw new RuntimeException( sprintf( '%s is not a propriety of file', print_r( $propriety, true ) ) );
			}

			return $this->file[ $propriety ];
		}
	}
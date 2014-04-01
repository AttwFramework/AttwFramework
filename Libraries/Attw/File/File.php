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
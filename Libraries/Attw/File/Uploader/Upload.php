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
 
	namespace Attw\File\Uploader;

	use Attw\File\File;
	use \RuntimeException;

	/**
	 * Uplaod files
	*/
	class Upload{
		/**
		 * Upload a file
		 *
		 * @param instanceof Attw\File\File $file File to upload
		 * @param string $directory Directory to upload file
		 * @param boolean $createDir Create directory if doesn't exists
		 * @throws \RuntimeException case param $createDir is false and directory doesn't exists
		*/
		public function upload( File $file, $directory, $createDir = true ){
			if( !is_dir( $directory ) ){
				if( $createDir ){
					mkdir( $directory );
				}else{
					throw new RuntimeException( 'Directory doesn\'t exists: ' . print_r( $directory, true ) );
				}
			}

			return move_uploaded_file( $file->tmp_name, $directory . DS . $file->name );
		}
	}
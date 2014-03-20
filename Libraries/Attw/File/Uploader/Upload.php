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
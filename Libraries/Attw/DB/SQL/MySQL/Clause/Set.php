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
 
	namespace Attw\DB\SQL\MySQL\Clause;

	use Attw\DB\SQL\AbstractClause;
    use Attw\DB\SQL\MySQL\Operator\AndO;

	class Set extends AbstractClause{
        private $data;

		public function __construct( $data ){
			$this->data = $data;
		}

		protected function constructSql(){
            if( is_array( $this->data ) ){
			    $this->sql = sprintf( 'SET %s', new AndO( $this->data ) );
            }else{
                $this->sql = sprintf( 'SET %s', $this->data );
            }
		}
	}
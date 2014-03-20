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
 
	namespace Attw\DB\SQL\MySQL\Operator;

	use Attw\DB\SQL\AbstractOperator;
	use \LogicException;

	class Or extends AbstractOperator{
		const OPERATOR = 'OR';

		public function __construct( $a, $b = null ){
			$this->a = $a;
			$this->b = $b;
		}

		public function constructSql(){
			$a = $this->a;
			$b = $this->b;

			if( is_array( $a ) ){
				$this->sql = implode( ' OR ', $a );
			}else{
				if( !is_null( $b ) ){
					$this->sql = sprintf( '%s OR %s', $a, $b );
				}else{
					throw new LogicException( 'If the first argument is\'t an array, second argument must not be null' );
				}
			}
		}
	}
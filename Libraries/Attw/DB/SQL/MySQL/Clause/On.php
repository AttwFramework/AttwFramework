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
    
	namespace Attw\DB\SQL\MySQL\Clause;

	use Attw\DB\SQL\AbstractClause;

	class On extends AbstractClause{
		private $columns;

		public function __construct( $columns ){
			$this->columns = $columns;
		}

		protected function constructSql(){
            if( is_array( $this->columns ) ){
    			foreach( $this->columns as $column1 => $column2 ){
    				$columnsArr[] = new \Attw\DB\SQL\MySQL\Operator\Equal( $column1, $column2 );
    			}

    			$this->sql = sprintf( 'ON ( %s )', new \Attw\DB\SQL\MySQL\Operator\AndO( $columnsArr ) );
            }else{
                $this->sql = sprintf( 'ON ( %s )', $this->columns );
            }
		}
	}
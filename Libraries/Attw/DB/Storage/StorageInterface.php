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
 
    namespace Attw\DB\Storage;
    
    use Attw\DB\Storage\TransactionsInterface;

    /**
     * Interface to storages
    */
    interface StorageInterface extends TransactionsInterface{
        /**
         * To insert something
         *
         * @param string $storageLocal local to inert
         * @param array $data data to insert
        */
        public function insert( $storageLocal, array $data );

        /**
         * To delete something
         *
         * @param string $storageLocal local to delete
         * @param array $where
        */
        public function delete( $storageLocal, array $where );

        /**
         * To update something
         *
         * @param string $storageLocal local to update
         * @param array $data data to set
         * @param array $where
        */
        public function update( $storageLocal, array $data, array $where );

        /**
         * To fetch something
         *
         * @param string $storageLocal local to update
         * @param string | array data to fetch
        */
        public function select( $storageLocal, $data = '*' );

        /**
         * To count results
         *
         * @return integer
        */
        public function count();
    }
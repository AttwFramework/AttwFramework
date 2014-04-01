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
 
    namespace Attw\Model;

    use Attw\DB\Storage\PDOStorage;
    use Attw\DB\Storage\Entity\EntityStorage;
    use Attw\Core\Object;
    use Attw\DB\Collection as DBCollection;
    
    /**
     * Interface to models
    */
    abstract class AbstractModel extends Object{
        /**
         * Use to data persistence
         *
         * @var instanceof Attw\DB\Storage\PDOStorage (initally)
        */
        protected $storage;

        /**
         * Use to data entity persistence
         * 
         * @var instanceof Attw\DB\Storage\PDO\EntityStorage
        */
        protected $entity;
        
        /**
         * Configure the storage and storage to entities
         *
         * @throws \RuntimeException case is not defined a default connection
        */
        public function __construct(){
            if( DBCollection::exists( 'Default' ) ){
                $connection = DBCollection::get( 'Default' );
            }else{
                throw new RuntimeException( 'Define a default connection in Configs class' );
            }
            
            $this->storage = new PDOStorage( $connection->getConnection(), $connection->getDriver() );
            $this->entity = new EntityStorage( $this->storage );
        }
    }
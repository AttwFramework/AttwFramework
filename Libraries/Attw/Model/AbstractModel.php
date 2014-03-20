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
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
 
    namespace Attw\Model\Entity;

    use \RuntimeException;
    use Attw\Core\Object;
    use \ReflectionProperty;
    
    /**
     * Interface to an entity
     *
     * @package FCodePHP.Entity
    */
    abstract class AbstractEntity extends Object{
        private $fields = array();

        /**
         * Constructor to entity
         * List the table columns to variable $this->fields
        */
        public function __construct(){
            $this->fields = get_object_vars( $this );
            unset( $this->fields['fields'] );
        }

        /**
         * Setter
         *
         * @param string $column column to set
         * @param string $value value to set
         * @throws \RuntimeException case param $column is a invalid column
         * @example
         * $entity->valid_column = $value;
        */
        public function __set( $column, $value ){
            if( !$this->hasField( $column ) ){
                throw new RuntimeException( sprintf( '%s isn not a column of the table %s', 
                                                     $column, 
                                                     $this->table ) );
            }

            $this->{$column} = print_r( $value, true );
        }

        /**
         * Getter
         *
         * @param string $column column to get value
         * @throws \RuntimeException case param $columns is an invalid column
         * @return string value of column
        */
        public function __get( $column ){
            if( !$this->hasField( $column ) ){
                throw new RuntimeException( sprintf( '%s isn not a column of the table %s', 
                                                     $column, 
                                                     $this->table ) );
            }

            $column = get_object_vars( $this );
            return $columns[ $column ];
        }

        /**
         * Get table of entity
         *
         * @return string
        */
        public function getTable(){
            return $this->table;
        }
        
        /**
         * Get all columns with values of the entity
         *
         * @return array
        */
        public function getColumns(){
            $columns = get_object_vars( $this );
            unset( $columns['table'], $columns['fields'] );

            $null = 0;

            foreach( $columns as $value ){
                if( is_null( $value ) ){
                    $null++;
                }
            }

            if( $null == count( $columns ) ){
                throw new RuntimeException( 'To use this entity, some column must have a value different of null' );
            }

            return $columns;
        }

        /**
         * Verify if a column is a valid field of the table
         *
         * @param string $field
         * @return boolean
        */
        public function hasField( $field ){
            return in_array( $field, array_keys( $this->fields ) );
        }

        /**
         * Get the primary key of the table
         *
         * @throws \RuntimeException case exists two primary keys
         * @throws \RuntimeException case is not defined a primary key
         * @return array
        */
        public function getPrimaryKey(){
            $primaries = array();

            foreach( $this->getColumns() as $field => $value ){
                $property = new ReflectionProperty( get_class( $this ), $field );

                if( '%2F%2A%2A%0D%0A%09%09+%2A+%40key+PRIMARY+KEY%0D%0A++++%09%2A%2F' === urlencode( $property->getDocComment() ) ){
                    $primaries[ $field ] = $value;
                }
            }

            if( count( $primaries ) > 1 ){
                throw new RuntimeException( 'Define a only primary key on entity: ' . get_class( $this ) );
            }elseif( count( $primaries ) == 0 ){
                throw new RuntimeException( 'Define a primary key on entity with the comment "/** * PRIMARY KEY */" in entity: ' . get_class( $this ) );
            }

            return $primaries;
        }
    }
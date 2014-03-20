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
 
    namespace Attw\Paginator;
    
    use Attw\Paginator\PaginatorInterface;
    
    /**
     * Paginate an array
     * 
     * @example
     * $array = [ '1', '2', '3', '4', '5', '6' ];
     * $paginator = new ArrayPaginator( $array, 2, 2, ArrayPaginator::SORT_DESC );
     * $arrayPaginated = $paginator->getPaginated();
     * print_r( $arrayPaginated );
     * // array( [0] => 4, [1] => 3 )
    */
    class ArrayPaginator implements PaginatorInterface{
        /**
         * Organization type: desc
         *
         * @const string
        */
        const SORT_DESC = 'desc';

        /**
         * Organization type: asc
         *
         * @const string
        */
        const SORT_ASC = 'asc';
        
        /**
         * Data to paginate
         *
         * @var array
        */
        private $data;

        /**
         * Limit of pagination
         *
         * @var integer
        */
        private $limit;

        /**
         * Current page of pagination
         *
         * @var integer
        */
        private $currentPage;

        /**
         * Organization type
         *
         * @var string (asc|desc)
        */
        private $sort;

        /**
         * Array already paginated
         *
         * @var array
        */
        private $slicedArray;
        
        /**
         * Constructor of paginator
         *
         * @param array $data data to paginate
         * @param integer $limit limit per page
         * @param integer $currentPage current page number of pagination
         * @param string $sort organization type. Can be asc (Paginator\ArrayPaginator::SORT_ASC) or desc (Paginator\ArrayPaginator::SORT_DESC)
         * @throws \UnexpectedValueException case param $sort is diferent of 
          * Paginator\ArrayPaginator::SORT_ASC and Paginator\ArrayPaginator::SORT_DESC
        */
        public function __construct( array $data, $limit, $currentPage, $sort = null ){
            $this->data = $data;
            $this->limit = ( int ) ceil( $limit );
            $this->currentPage = $currentPage - 1;

            $sort = trim( $sort );
            if( !is_null( $sort ) && $sort !== '' ){
                if( strtolower( $sort ) != self::SORT_ASC && strtolower( $sort ) != self::SORT_DESC ){
                    throw new \UnexpectedValueException( 'The sort must be ascendant or descendant' );
                }
            }
            $this->sort = ( !is_null( $sort ) && $sort !== '' ) ? $sort : null;
            
            $this->createArrayPaginated();
        }
        
        /**
         * Paginate the array and set $this->slicedArray
        */
        private function createArrayPaginated(){
            $currentIndex = ( $this->currentPage * $this->limit );
            $sliced = array_slice( $this->data, $currentIndex, $this->limit );
            
            if( !is_null( $this->sort ) ){
                if( $this->sort == self::SORT_ASC ){
                    arsort( $sliced );
                }elseif( $this->sort == self::SORT_DESC ){
                    krsort( $sliced );
                }
            }
            
            $this->slicedArray = $sliced;
        }
        
        /**
          * Get the array paginated
          *
          * @return array $this->slicedArray
        */
        public function getPaginated(){
            return $this->slicedArray;
        }
        
        /**
         * Count how pages was paginated
         * @see Contable Interface
         *
         * @return integer
        */
        public function count(){
            return ceil( count( $this->data ) / $this->limit );
        }
        
        /**
         * Current page of pagination
         *
         * @return integer $this->currentPage
        */
        public function getCurrentPage(){
            return $this->currentPage;
        }
    }
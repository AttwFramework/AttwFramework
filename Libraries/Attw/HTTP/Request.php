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
 
    namespace Attw\HTTP;
    
    use Attw\HTTP\Request\RequestInterface;
    
    /**
     * Request handler
     *
     * @resource Get request methods: POST, QUERY, FILES, PUT, DELETE and AJAX
     * @resource Verify request type
     * @resource Send a request with cUrl extension
    */
    class Request{
        const POST_METHOD = 'POST';
        const QUERY_METHOD = 'GET';
        const FILES_METHOD = 'FILES';
        const PUT_METHOD = 'PUT';
        const DELETE_METHOD = 'DELETE';
        const AJAX_METHOD = 'xmlhttprequest';
        
        /**
         * Querystrings
         *
         * @var array
        */
        private $query;

        /**
         * Posts
         *
         * @var array
        */
        private $post;

        /**
         * Files
         *
         * @var array
        */
        private $files;

        /**
         * Server
         *
         * @var array
        */
        private $server;

        /**
         * Request method
         *
         * @var string
        */
        private $method;
        
        /**
         * Constructor of Request
         * Define teh variables
        */
        public function __construct( 
            array $query = array(), 
            array $post = array(), 
            array $files = array(), 
            array $server = array() 
        ){
            $this->query = ( count( $query ) > 0 ) ? $query : $_GET;
            $this->post = ( count( $post ) > 0 ) ? $post : $_POST;
            $this->files = ( count( $files ) > 0 ) ? $files : $_FILES;
            $this->server = ( count( $server ) > 0 ) ? $server : $_SERVER;
        }
        
        /**
         * Get a querystring requet
         *
         * @param string $propriety
         * @return mixed
        */
        public function query( $propriety ){
            $query = ( object ) $this->query;
            return $query->{ $propriety };
        }
        
        /**
         * Get a post requet
         *
         * @param string $propriety
         * @return mixed
        */
        public function post( $propriety ){
            $post = ( object ) $this->post;
            return $post->{ $propriety };
        }
        
        /**
         * Get a server propriety
         *
         * @param string $propriety
         * @return mixed
        */
        public function server( $propriety ){
            $server = ( object ) $this->server;
            return $serve->{ $propriety };
        }
        
        /**
         * Verify if request is a post request
         *
         * @return boolean
        */
        public function isPost(){
            return ( strtoupper( $this->getMethod() ) === self::POST_METHOD );
        }
        
        /**
         * Verify if request is a file request
         *
         * @return boolean
        */
        public function isFiles(){
            return ( strtoupper( $this->getMethod() ) === self::FILES_METHOD );
        }

        /**
         * Verify if request is a querystring request
         *
         * @return boolean
        */
        public function isQuery(){
            return ( strtoupper( $this->getMethod() ) === self::QUERY_METHOD );

        }
        
        /**
         * Verify if request is a ajax request
         *
         * @return boolean
        */
        public function isAjax(){
            return ( isset( $this->server()->HTTP_X_REQUESTED_WITH ) 
                    && strtolower( $this->server()->HTTP_X_REQUESTED_WITH ) === self::AJAX_METHOD );
        }
        
        /**
         * Get the requet method
         *
         * @return string
        */
        public function getMethod(){
            return $this->server()->REQUEST_METHOD;
        }
        
        /**
         * Send a request
         * Needs cUrl extension
         *
         * @param instanceof Attw\HTTP\Request\RequestInterface $request
         * @return mixed
        */
        public function send( RequestInterface $request ){
            return $request->send();
        }
    }
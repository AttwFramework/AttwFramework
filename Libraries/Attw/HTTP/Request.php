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
         * @param string $property
         * @return mixed
        */
        public function query( $property ){
            $query = ( object ) $this->query;
            return $query->{ $property };
        }
        
        /**
         * Get a post requet
         *
         * @param string $property
         * @return mixed
        */
        public function post( $property ){
            $post = ( object ) $this->post;
            return $post->{ $property };
        }
        
        /**
         * Get a server property
         *
         * @param string $property
         * @return mixed
        */
        public function server( $property ){
            $server = ( object ) $this->server;
            return $server->{ $property };
        }

        /**
         * Get a file property
         *
         * @param string $property
         * @return array
        */
        public function file( $property ){
            $files = ( object ) $this->files;
            return $files->{ $property };
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
            return ( isset( $this->server( 'HTTP_X_REQUESTED_WITH' ) ) 
                    && strtolower( $this->server( 'HTTP_X_REQUESTED_WITH' ) ) === self::AJAX_METHOD );
        }
        
        /**
         * Get the requet method
         *
         * @return string
        */
        public function getMethod(){
            return $this->server( 'REQUEST_METHOD' );
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

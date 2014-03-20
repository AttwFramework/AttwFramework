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

    /**
     * HTTP Responses
    */
    class Response{
        /**
         * Messages to status codes
         * 
         * @var array
        */
        private $messages = array(
            100 => 'Continue',
    		101 => 'Switching Protocols',
    		200 => 'OK',
    		201 => 'Created',
    		202 => 'Accepted',
    		203 => 'Non-Authoritative Information',
    		204 => 'No Content',
    		205 => 'Reset Content',
    		206 => 'Partial Content',
    		300 => 'Multiple Choices',
    		301 => 'Moved Permanently',
    		302 => 'Found',
    		303 => 'See Other',
    		304 => 'Not Modified',
    		305 => 'Use Proxy',
    		307 => 'Temporary Redirect',
    		400 => 'Bad Request',
    		401 => 'Unauthorized',
    		402 => 'Payment Required',
    		403 => 'Forbidden',
    		404 => 'Not Found',
    		405 => 'Method Not Allowed',
    		406 => 'Not Acceptable',
    		407 => 'Proxy Authentication Required',
    		408 => 'Request Time-out',
    		409 => 'Conflict',
    		410 => 'Gone',
    		411 => 'Length Required',
    		412 => 'Precondition Failed',
    		413 => 'Request Entity Too Large',
    		414 => 'Request-URI Too Large',
    		415 => 'Unsupported Media Type',
    		416 => 'Requested range not satisfiable',
    		417 => 'Expectation Failed',
    		500 => 'Internal Server Error',
    		501 => 'Not Implemented',
    		502 => 'Bad Gateway',
    		503 => 'Service Unavailable',
    		504 => 'Gateway Time-out',
    		505 => 'Unsupported Version'
        );

        /**
         * HTTP Status Code
         *
         * @var integer
        */
        private $statusCode = 200;
        
        /**
         * Header to be send
         *
         * @var array
        */
        private $headersToSend;
        
        /**
         * Constructor of response
         *
         * @param integer $statusCode Set a status
        */
        public function __construct( $statusCode = null ){
            $this->statusCode = ( is_null( $statusCode ) ) ? http_response_code() : $statusCode;
        }
        
        /**
         * Send a HTTP Response
         *
         * @param string $name
         * @param string $value
         * @return mixed Header function
        */
        public function sendHeader( $name, $value = null ){
            return ( $value == null ) ? header( $name ) : header( sprintf( '%s: %s', $name, $value ) );
        }

        /**
         * Send all header registred
        */
        public function sendAllHeaders(){
            foreach( $this->headersToSend as $header ){
                $headerName = $header['name'];
                $headerValue = $header['value'];

                $this->sendHeader( $headerName, $headerValue );
            }
        }
        
        /**
         * Set the status code
         *
         * @param integer $code 
        */
        public function setStatusCode( $code ){
            $this->statusCode = $code;
        }

        /**
         * Get the current status code
         *
         * @return integer
        */
        public function getStatusCode(){
            return $this->statusCode;
        }
        
        /**
         * Attach a HTTP Reponse to send
         *
         * @param string | array $name
         * @param string $value
        */
        public function addHeader( $name, $value = null ){
            $this->headersToSend[] = array( 'name' => $name, 'value' => $value );
        }
        
        /**
         * Send a Location HTTP Response
         *
         * @param string $url URL to redrect
         * @param integer $status Redirect when is with indicated status
        */
        public function redirect( $url, $status = 200 ){
            if( $status != 200 ){
                if( $this->getStatusCode() == $status ){
                    $this->sendHeader( 'Location', $url );
                }
            }else{
                $this->sendHeader( 'Location', $url );
            }
        }
    }
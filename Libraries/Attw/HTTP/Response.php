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
         * HTTP Protocol default
         *
         * @var string
        */
        private $protocol = 'HTTP/1.1';

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
        public function __construct( $statusCode = null, $protocol = 'HTTP/1.1' ){
            $this->statusCode = ( is_null( $statusCode ) ) ? http_response_code() : $statusCode;
            $this->setProtocol( $protocol );
        }
        
        /**
         * Set HTTP protocol
         *
         * @param string $protocol
        */
        public function setProtocol( $protocol ){
            $this->protocol = ( string ) $protocol;
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

        /**
         * Send a HTTP status code
         *
         * @param int $statusCode
        */
        public function sendStatusCode( $statusCode ){
            $this->statusCode = $statusCode;
            if( in_array( $statusCode, array_keys( $this->messages ) ) ){
                $this->sendHeader( sprintf( '%s %s %s', $this->protocol, 
                                                        $statusCode, 
                                                        $this->messages[ $statusCode ] ) );
            }else{
                $this->sendHeader( sprintf( '%s %s', $this->protocol, $statusCode );
            }
        }
    }
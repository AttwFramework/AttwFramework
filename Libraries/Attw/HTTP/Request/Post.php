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
 
    namespace Attw\HTTP\Request;
    
    use Attw\HTTP\Request\iRequest;
    use \RuntimeException;
    
    /**
     * Create a post request
     * Needs cUrl extension
     *
     * @package FCodePHP.HTTP
    */
    class Post implements RequestInterface{
        /**
         * Constructor of Pst request
         *
         * @param string $url Url to send the request
         * @param array $fields Fileds to send in the request
        */
        public function __construct( $url, array $fields ){
            $this->url = $url;
            $this->fields = $fields;
        }
        
        /**
         * Create a string for fields
         *
         * @return string Fields string
        */
        private function getFieldsString(){
            $fieldsString = http_build_query( $this->fields );

            return $fieldsString;
        }
        
        /**
         * Send the request
         *
         * @return mixed Return of requested url
         * @throws \Exception case occurre some error
        */
        public function send(){
            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, $this->url );
            curl_setopt( $ch, CURLOPT_POST, count( $this->fields ) );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->getFieldsString() );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            
            $return = curl_exec( $ch );
            
            if( !$return ){
                throw new RuntimeException( 'An error occurred with the request: ' . curl_error( $ch ) );
            }
            
            curl_close( $ch );
            
            return $return;
        }
    }
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
 
    namespace Attw\HTTP\Request;
    
    use Attw\HTTP\Request\iRequest;
    use \Exception;
    
    /**
     * Send a Query request
     *
     * @package FCodePHP.HTTP
    */
    class Query implements RequestInterface{
        /**
         * Constructor of Query request
         *
         * @param string $url Url to request
         * @param array $fields Fields of request
        */
        public function __construct( $url, array $fields = array() ){
            $this->url = $url;
            $this->fields = $fields;
        }
        
        /**
         * Create a string of fields
         *
         * @return string Url with fields
        */
        private function getFinalUrl(){
            if( count( $this->fields ) > 0 ){
                foreach( $this->fields as $key => $value ){
                    $fields[] = $key . '=' . $value;
                }
                
                $fields = implode( '&', $fields );
                
                $finalUrl = $this->url . '?' . $fields;
                
                return $finalUrl;
            }

            return $this->url;
        }
        
        /**
         * Send the request
         *
         * @return mixed Return of requested url
         * @throws \Exception case occurre some error
        */
        public function send(){
            $ch = curl_init();
            
            curl_setopt( $ch, CURLOPT_URL, $this->getFinalUrl() );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            
            $return = curl_exec( $ch );
            
            if( !$return ){
                throw new Exception( 'An error occurred with the request: ' . curl_error( $ch ) );
            }
            
            curl_close( $ch );
            
            return $return;
        }   
    }
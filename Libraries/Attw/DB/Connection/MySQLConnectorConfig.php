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
    
    namespace Attw\DB\Connection;
    
    use Attw\DB\Connection\AbstractConnectorConfig;
    
    /**
     * MySQL Connector Config
    */
    class MySQLConnectorConfig extends AbstractConnectorConfig{
        /**
         * Constructor of MySQL Config
         * Set the params to connection
         *
         * @param string $host
         * @param string $dbname
         * @param string $user
         * @param string $password
         * @param integer $port
        */
        public function __construct( $host, $dbname, $user, $password, $port = null ){
            $this->host = $host;
            $this->dbname = $dbname;
            $this->port = $port;
            $this->user = $user;
            $this->password = $password;
        }
        
        /**
         * Get DSN to connector
         *
         * @return string
        */
        public function getDsn(){
            return  ( !is_null( $this->port ) ) 
                    ? sprintf( 'mysql:host=%s;dbname=%s;port=%s', $this->host, $this->dbname, $this->port ) 
                    : sprintf( 'mysql:host=%s;dbname=%s', $this->host, $this->dbname );
        }
    }
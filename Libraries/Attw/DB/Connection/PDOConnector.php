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
    use \PDO;
    
    class PDOConnector implements iConnector{
        /**
         * Configurations to connection
         *
         * @var instanceof Attw\DB\Connection\AbstractConnectorConfig
        */
        private $config;
        
        /**
         * Instance of \PDO
         *
         * @var instanceof \PDO
         */
        private $instance;
        
        public function __construct( AbstractConnectorConfig $config ){
            $this->config = $config;
            $this->connect();
        }
        
        public function connect(){
            if( !$this->isConnected() ){
                $this->instance = new PDO(
                    $this->config->getDsn(),
                    $this->config->getUser(),
                    $this->config->getPassword()
                );
                
                $this->instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
        }
        
        public function disconnect(){
            $this->instance = null;
        }
        
        public function getConnection(){
            return $this->instance;
        }
        
        public function isConnected(){
            return ( $this->instance instanceof PDO );
        }
        
        public function getDriver(){
            return $this->instance->getAttribute( PDO::ATTR_DRIVER_NAME );
        }
    }
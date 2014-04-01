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
 
    namespace Attw\DB\Storage\PDO;

    use Attw\DB\Exception\StatementException;
    use \PDOException;
    
    /**
     * Interface to statements with PDO
    */
    abstract class AbstractPDOStatement{
        /**
         * Instance of PDO
         *
         * @var instanceof \PDO
        */
        protected $pdo;

        /**
         * SQL to execute
         *
         * @var string
        */
        protected $sql;

        /**
         * Params to pass as param on \PDOStatement::bindParam()
         *
         * @var array
        */
        protected $bindParams = array();

        /**
         * Params to pass as param on \PDOStatement::execute()
         *
         * @var array
        */
        protected $executeBindParams = array();

        /**
         * Execute the statement
         *
         * @return boolean
        */
        public function execute( array $bindParams = array() ){
            if( count( $bindParams ) > 0 ){
                $this->executeBindParams = array_merge( $this->executeBindParams, $bindParams );
            }

            try{
                foreach( $this->bindParams as $param ){
                    $this->stmt->bindParam( $param['var'], $param['value'], $param['type'] );
                }
                
                return $this->stmt->execute( $this->executeBindParams );
            }catch( PDOException $e ){
                throw new StatementException( $e->getMessage() );
            }
        }
        
        /**
         * Set the params to pass in \PDOStatement::execute()
         *
         * @param mixed
        */
        public function setBindParams(){
            $params = func_get_args();
            
            foreach( $params as $key => $value ){
                if( is_array( $value ) ){
                    $this->executeBindParams = $value;
                }else{
                    $this->executeBindParams = array_merge( $this->executeBindParams, array( $key => $value ) );
                }
            }
        }

        /**
         * Attach a variable to set
         *
         * @param string $variable
         * @param mixed $value
         * @param mixed $type
        */
        public function bindParam( $variable, $value, $type = null ){
            $this->bindParams[] = array(
                'var' => print_r( $variable, true ),
                'value' => print_r( $value, true ),
                'type' => $type
            );
        }
    }
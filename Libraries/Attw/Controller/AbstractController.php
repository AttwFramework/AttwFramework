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
 
    namespace Attw\Controller;
    
    use Attw\Core\Object;
    use \InvalidArgumentException;
    use \RuntimeException;

    /**
     * Abstract controller to be a base to the other controllers
    */
    abstract class AbstractController extends Object{
        /**
         * Method that will called when a action be not defined by user
         * Allowed to be replaced
        */
        public function index(){}
        
        /**
         * Instance a model
         *
         * @param string $model Model name to instance
         * @throws \InvalidArgumentException case param $model is not a string
         * @throws \RuntimeException case model do not exists
         * @return instanceof $model 
        */
        protected function loadModel( $model ){
            if( !is_string( $model ) ){
                throw new InvalidArgumentException( 'Model argument must be an string' );
            }
            
            $model_name = 'MVC\Model\\' . $model;

            if( !class_exists( $model_name ) ){
                throw new RuntimeException( 'View not found: ' . $model_name );
            }

            $model_instance = new $model_name;
            
            return $model_instance;
        }
        
        /**
         * Instance a view
         *
         * @param $view View name to instance
         * @throws \InvalidArgumentException case param $view is not a string
         * @throws \RuntimeException case view do not exists
         * @return instanceof $view
        */
        protected function loadView( $view ){
            if( !is_string( $view ) ){
                throw new InvalidArgumentException( 'View argument must be an string' );
            }
            
            $view_name = 'MVC\View\\' . $view;
            
            if( !class_exists( $view_name ) ){
                throw new RuntimeException( 'View not found: ' . $view );
            }
            
            $view_instance = new $view_name;
            
            return $view_instance;
        }
    }
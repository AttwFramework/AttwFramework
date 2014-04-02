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
                throw new RuntimeException( 'Model not found: ' . $model_name );
            }

            $model_instance = new $model_name;
            
            return $model_instance;
        }
        
        /**
         * Instance a view
         *
         * @param string $view View name to instance
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
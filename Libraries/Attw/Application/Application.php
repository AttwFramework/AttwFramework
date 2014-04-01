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
 
    namespace Attw\Application;
    
    use Attw\HTTP\Request;
    use Attw\Router\RoutingManager;
    use Attw\HTTP\Response;
    use Attw\Config\Configs;

    class Application{
        const DEFAULT_CONTROLLER = 'Index';
        const DEFAULT_ACTION = 'index';
        
        public function execute(){
            $url = ( isset( $_GET['url'] ) ) ? $_GET['url'] : '';

            RoutingManager::setParams( $url, self::DEFAULT_CONTROLLER, self::DEFAULT_ACTION );
            
            $controller = 'MVC\Controller\\' . RoutingManager::getController();
            $action = RoutingManager::getAction();
            $getParams = RoutingManager::getParams();
            
            if( !class_exists( $controller ) || !method_exists( new $controller, $action ) || is_null( $action ) ){
                if( Configs::exists( 'PageErrors' ) ){
                    $pages = Configs::get( 'PageErrors' );

                    if( isset( $pages['404'] ) ){
                        $response = new Response();
                        $response->redirect( $pages['404'] );
                    }
                }else{
                    throw new \Exception( 'Controller and/or action not found' );
                }
            }

            $_GET = array_merge( $getParams, RoutingManager::getQueryStrings( $_SERVER['REQUEST_URI'] ) );

            $controllerInstance = new $controller;
            $controllerInstance->{$action}();
        }
    }
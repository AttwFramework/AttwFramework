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
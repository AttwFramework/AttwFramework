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
 
	namespace Router;

	class Manager2{
		/**
		 * List of routes
		 * @var array
		*/
		private $routes;
		private $controller;
		private $action;

		public function setRoute( $route, $controllerAction ){
			$ca = explode( '.', $controllerAction );
			$this->controller = $ca[0];
			$this->action = $cs[1];
			$this->routes[] = [ 'route' => $route, 
								'params' => $this->interpretParams( $route ),
								'no-params' => $this->interpretNoParams( $route ),
								'controller' => $this->controller,
								'action' => $this->action ];
		}

		public function getController(){
			return ( string ) $this->controller;
		}

		public function getAction(){
			return ( string ) $this->action;
		}

		private function interpretParams( $route ){
			$routesExploded = explode( '/', $route );

			foreach( $routesExploded as $part ){
				$firstCaracter = substr( $part, 0, 1);

				if( $firstCaracter == ':' ){
					$params[] = str_replace( ':', '', $part );
				}
			}

			return $params;
		}

		private function interpretNoParams( $route ){
			$routesExploded = explode( '/', $route );

			foreach( $routesExploded as $key => $part ){
				$firstCaracter = substr( $part, 0, 1 );

				if( $firstCaracter != ':' ){
					$noParamss[ $key ] = $part;
				}
			}

			return $noParams;
		}

		public function getParams( $url, $defaultController, $defaultAction ){
			
		}

		public function routeExists( $controller, $action ){
			$exists = false;

			foreach( $this->routes as $route ){
				if( $route['controller'] == $controller && $route['action'] == $action ){
					$exists = true;
				}
			}

			return $exists;
		}
	}
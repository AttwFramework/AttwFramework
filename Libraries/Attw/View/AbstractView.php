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
 
    namespace Attw\View;
    
    use Attw\View\ViewInterface;
    use Attw\Config\Configs;
    use Attw\Core\Object;
    use \Exception;
    use \InvalidArgumentException;
    use \RuntimeException;
    use \Smarty;
    
    /**
     * Interface to view
    */
    abstract class AbstractView extends Object implements ViewInterface{
        /**
         * Instance of smarty
         *
         * @var instanceof \Smarty
        */
        protected $smarty;

        /**
         * Template file .tpl for Smarty
         *
         * @var string
        */
        private $tplFile;

        /**
         * Vars to template
         *
         * @var array
        */
        protected $vars = array();
        
        /**
         * Define, if is defined, a temporary path
         *  to save the templates
         *
         * @throws \Exception case is not defined the paths of the project
        */
        public function __construct(){
            if( !Configs::exists( 'Paths' ) ){
                throw new Exception( 'Define an array with project paths' );
            }

            $this->smarty = new Smarty();

            $paths = Configs::get( 'Paths' );
            
            if( isset( $paths['Temporary'] ) ){
                $this->smarty->caching = true;
                $this->smarty->cache_lifetime = 120;
                $this->smarty->setCacheDir( $paths['Temporary']  );
            }
        }

        /**
         * Set the template file to view
         *
         * @param string $file template file .tpl
         * @throws \InvalidArgumentException case param $file is not a string
         * @throws \Exception case is not defined a path for templates
        */
        public function setTplFile( $file ){
            if( !is_string( $file ) ){
                throw new InvalidArgumentException( sprintf( '%s::%s: the file must be a string', 
                                                    get_class( $this ), 
                                                    __METHOD__ ) );
            }
            
            $paths = Configs::get( 'Paths' );
            
            if( !isset( $paths['Templates'] ) ){
                throw new Exception( 'Define a path for templates' );
            }
            
            $templatesPath = $paths['Templates'];
            
            $file = $templatesPath . DS . $file;
        
            if( !is_file( $file ) ){
                throw new RuntimeException( 'Template not found: ' . $file );
            }
            
            $this->tplFile = $file;
        }
        
        /**
         * Renderer the view with Smarty
         *
         * @param array $vars variables to template
         * @return mixed view rendered
        */
        public function render( array $vars = array() ){
            if( count( $vars ) > 0 ){
				foreach( $vars as $var => $value ){
					$this->vars[ $var ] = $value;
				}
			}
			
            $this->toRender();
            
            $this->smarty->display( $this->tplFile );
        }

        /**
         * Set a var to template
         * @param string $var Var to set
         * @param mixed $value
        */
        public function __set( $var, $value ){
            $this->vars[ $var ] = $value;
        }
        
        /**
         * Set the variables of Smarty
         *
         * @param array $vars variables to template
        */
        abstract protected function toRender();
    }
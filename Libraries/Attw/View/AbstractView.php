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
<?php
    namespace MVC\Controller;
    
    use Attw\Controller\AbstractController;

    class Index extends AbstractController{
        public function index(){
            $view = $this->loadView( 'Index' );
			$view->message = 'Hello, world!';
			$view->setTplFile( 'index.tpl' );
			$view->render();
        }
    }
<?php
    namespace MVC\Controller;
    
    use Attw\Controller\AbstractController;

    class Index extends AbstractController{
        public function index(){
            $view = $this->loadView( 'Index' );
			$view->message = 'This message was puted here with <b>Smarty</b>.';
			$view->setTplFile( 'index.tpl' );
			$view->render();
        }
    }
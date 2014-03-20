<?php
    namespace MVC\View;
    
    use Attw\View\AbstractView;
    
    class Index extends AbstractView{
        protected function toRender(){
			$this->smarty->assign( 'message', $this->vars['message'] );
		}
    }
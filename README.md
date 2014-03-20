AttwFramework - Basic
==============
AttwFramework is a MVC micro framework to simple projects developments.

##Model


##Controllers
Default action: ``index``

###Controllers nomenclature
All controllers must inciate with upper letter

###Load models
To load a model, use the method: ``Attw\Controller\AbstractController::loadModel( string Model )``

###Load views
To load views, use the method: ``Attw\Controller\AbstractController::loadView( string View )``

```php
namespace MVC\Controller;

use Attw\Controller\AbstractController;
use Attw\HTTP\Request;

class Messages extends AbstractController{
	public function add(){
		$request = new Request();

		if( $request->isPost() ){
			$message = $request->post( 'message' );

			$messages = $this->loadModel( 'Messages' );
			$messages->save( $message );
		}
	}
}
```

##Views/Templates
The templates are renderer with Smarty library.
A view, per example, would be implemented:
MVC/View/Templates/hello.tpl
```html
<form method="post">
	<input type="text" name="name" /><br />
	<input type="submit" />
</form>
Hello, {$name}
```
MVC/View/Hello.php
```php
namespace MVC\View;

use Attw\View\AbstractView;

class Hello extends AbstractView{
	protected function toRender(){
		$this->smarty->assign( 'name', $this->vars['text'] );
	}
}
```
```php
namespace MVC\Controller;

use Attw\Controller\AbstractController;
use Attw\HTTP\Request;

class Hello extends AbstractController{
	public function index(){
		$request = new Request();
		if( $request->isPost() ){
			$view = $this->loadView( 'Hello' );
			$view->setTplFile( 'hello.tpl' );
			$view->render( [ 'name' => $request->post( 'name' ) ] );
		}
	}
}
```
##Routing
The routes will be defineds with ``Attw\Router\RoutingManager::add( mixed $params, array $controllerAndAction )``
###Example
```php
use Attw\Router\RoutingManager;

RoutingManager::add( 'id', [ 'controller' => 'Users', 'action' => 'get' ] );
//Url: http://domain.com/user/get/1
//To use id: $_GET['id'] or using the Attw\HTTP\Request::query( string $key )
```
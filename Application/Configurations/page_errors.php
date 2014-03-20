<?php
	/**
	 * Page errors redirect
	*/
	use Attw\HTTP\Response;

	$response = new Response();

	$response->redirect( '404-page.html', 404 );
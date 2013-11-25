<?php 		

// in practice, you'd use an autoloader, probably via including an application_top from your framework here
# @TODO include your application_top here!

// DEMO DATA ONLY ------------------------------------------------
define('DIR_WEBROOT_RELATIVE', '/RESTfulPHP/');

require_once('../class/RestApiUtil.php');
require_once('../class/RestApi.php');
require_once('../class/RestApiExampleObjects.php');
require_once('../class/RestApiExampleObjectsChildren.php');
// ---------------------------------------------------------------

// strip relative path from request
$request_alias = substr($_SERVER['REQUEST_URI'], strlen(DIR_WEBROOT_RELATIVE));
$request_alias_pieces = explode('?', $request_alias);
$request_file = $request_alias_pieces[0];


// remove "api/" from the $request_file string
$request_file = strstr($request_file, '/');
$request_file = trim($request_file, '/');


// support HTTP_X_HTTP_METHOD_OVERRIDE
// (usecase: some hosts only allow GET / POST)
$request_method;
if( isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) && $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ){
	$request_method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
} else {
	$request_method = $_SERVER['REQUEST_METHOD'];
}

	
switch( $request_method ){
	case 'GET':
		try {
			$ApiObj = new RestApi();
			$ApiObj = $ApiObj->getInstance(array(
				'request' => $request_file
			));
			$r = $ApiObj->get(array(
				'GET' => $_GET	
			));
			
			if( ! isset($r['debug_mode']) || ! $r['debug_mode'] ) {
				header('content-type: application/json');
			}
			echo json_encode( RestApiUtil::utf8Encode($r['data']) );
		} catch( Exception $e ) {
			header('Error', true, $e->getCode() > 0 ? $e->getCode() : 400);
		}
		break;
	
	case 'POST':
		try {
			$ApiObj = new RestApi();
			$ApiObj = $ApiObj->getInstance(array(
				'request' => $request_file
			));
			$r = $ApiObj->post(array(
				'POST' => $_POST	
			));
				
			if( !$r['debug_mode'] ) {
				header('content-type: application/json');
			}
			echo json_encode( RestApiUtil::utf8Encode($r['data']) );
		} catch( Exception $e ) {
			header('Error', true, $e->getCode() > 0 ? $e->getCode() : 400);
		}
		break;
	
	case 'UPDATE':
		parse_str( file_get_contents('php://input'), $array );
		$_UPDATE = $array;
		unset($array);
	
		try {
			$ApiObj = new RestApi();
			$ApiObj = $ApiObj->getInstance(array(
				'request' => $request_file
			));
			$ApiObj->update(array(
				'UPDATE' => $_UPDATE	
			));
		} catch ( Exception $e ) {
			header('Error', true, $e->getCode() > 0 ? $e->getCode() : 400);
		}
		break;
	
	case 'PUT':
		parse_str( file_get_contents('php://input'), $array );
		$_PUT = $array;
		unset($array);
				
		try {
			$ApiObj = new RestApi();
			$ApiObj = $ApiObj->getInstance(array(
				'request' => $request_file
			));
			$ApiObj->put(array(
				'PUT' => $_PUT
			));
		} catch ( Exception $e ) {
			header('Error', true, $e->getCode() > 0 ? $e->getCode() : 400);
		}
		break;

	case 'DELETE':
		parse_str( file_get_contents('php://input'), $array );
		$_DELETE = $array;
		unset( $array );
		
		try {
			$ApiObj = new RestApi();
			$ApiObj = $ApiObj->getInstance(array(
				'request' => $request_file
			));
			$ApiObj->delete(array(
				'DELETE' => $_DELETE	
			));
		} catch ( Exception $e ) {
			header('Error', true, $e->getCode() > 0 ? $e->getCode() : 400);
		}	
		break;
}
		
		

		
		
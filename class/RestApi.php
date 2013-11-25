<?php

class RestApi {
	
	private 
		$id,
		$owner
	;

	
	public function __construct( $params = false ) {
	
		if( $params['request'] ) {
			// grab first piece of the request
			if( strlen($request = trim(strstr($params['request'], '/'), '/')) > 0 ) {
				// php 5.2 compatible
				$pieces = explode('/', $params['request']);
	
				if( is_numeric($pieces[0]) ) {
					$this->setId( $pieces[0] );
					$params['request'] = $request;
				}
				unset( $pieces );
			} else {
				// if the request is numeric, then it's an id
				if( is_numeric($params['request']) ) {
					$this->setId( $params['request'] );
					$params['request'] = '';
				}
			}
		}	
	}
	
	
	public function getInstance( $params ) {				
		if( isset($params['owner']) && is_object( $params['owner'] ) ) {
			$this->setOwner( $params['owner'] );
		}
		
		// if resource starts with "api/", strip it
		if( strpos($params['request'], 'api/' ) === 0 ){
			$params['request'] = substr($params['request'], 4);
		}
		
		if( $params['request'] ) {
			if( strlen($request = trim(strstr($params['request'], '/'), '/')) > 0 ) {
				// php 5.2 compatible
				$pieces = explode('/', $params['request']);
				$class = $pieces[0];
				unset( $pieces );
			} else {
				$class = $params['request'];
			}
		
			$class = get_class($this) . $class;
		
			$instance = new $class(array('request' => &$request));	
			$instance->setOwner( $this );
			
			if( $request ) {
				return $instance->getInstance(array(
					'request' => $request
				));
			}
			
			return $instance;
		}
	}
			
	public function getOwner() {
		return $this->owner;
	}
	
	protected function setOwner( $owner ) {
		$this->owner = $owner;
	}

	public function getId() {
		return $this->id;
	}
	
	protected function setId( $id ) {
		$this->id = (int)$id;
	}
	
	
}





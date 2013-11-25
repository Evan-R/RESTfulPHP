<?php

// you might access this like;
// api/ExampleObjects?isaid=whatwhat

class RestApiExampleObjects extends RestApi {

	public function get( $params = array() ){
		
		// test
// 		print_r( $params );
// 		exit;
		
		return array(
			'data' => array(
				'message' => 'here is your GET data!',
				'GET' => $params['GET']
			)
		);
	}
	
}


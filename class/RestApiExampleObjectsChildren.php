<?php

// you might access this like;
// api/ExampleObjects/4242/Children

class RestApiExampleObjectsChildren extends RestApi {
	
	public function get( $params = array() ){
		
		
		return array(
			'data' => array(
				'message' => "my owner's id is: " . $this->getOwner()->getId()	
			)
		);
		
		
	}
	
	
}


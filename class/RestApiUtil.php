<?php

class RestApiUtil {
	
	
	private function __construct(){
		//singleton
	}
	
	
	/**
	 * encodes a string / array values to utf8
	 * @param (mixed) $mixed
	 */
	static function utf8Encode( $mixed ) {
		if( is_array( $mixed ) ) {
			foreach( $mixed as $key => $value ) {
				$mixed[$key] = self::utf8Encode( $value );
			}
		} else {
			if( ! mb_check_encoding( $mixed, 'UTF-8') ) {
				$mixed = utf8_encode( $mixed );
			}
		}
	
		return $mixed;
	}
	
}


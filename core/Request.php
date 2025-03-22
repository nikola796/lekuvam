<?php

namespace App\Core;

class Request {

	public static function uri() {
		$uri = implode('/',
		array_slice(
			explode('/', $_SERVER['REQUEST_URI']), 2)
		);

		return urldecode($uri);
	}

	public static function method() {
		return $_SERVER['REQUEST_METHOD'];
	}
}
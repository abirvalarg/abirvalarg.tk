<?php
require_once 'db.php';

class User {
	function __construct(int $uid) {
	}

	public static function login(string $login, string $password) : User {
		return new User(0);
	}

	public static function register(string $login, string $password) : Bool {
		return false;
	}

	public static function exists(string $login) : Bool {
		return false;
	}
};
?>

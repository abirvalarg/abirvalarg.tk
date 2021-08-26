<?php
function csrf_token() : string {
	static $token = NULL;
	if($token === NULL) {
		$token = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(32/strlen($x)) )),1,32);
		setcookie('csrf', $token, 0, '/', '', true, false);
	}
	return $token;
}

function csrf_check(string $token) : bool {
	return isset($_COOKIE['csrf']) && ($_COOKIE['csrf'] === $token);
}
?>

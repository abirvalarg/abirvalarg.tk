<?php
require_once 'credentials.php';
function db() : Mysqli {
	static $conn = NULL;
	if($conn === NULL) {
		$conn = new Mysqli('127.0.0.1', DB_USER, DB_PASSWORD, 'abirvalarg_tk');
		if($conn->connect_errno !== 0) {
			$code = $conn->connect_errno;
			$error = $conn->connect_error;
			die("can't connect to database($code): $error");
		}
	}
	return $conn;
}
session_start();
?>

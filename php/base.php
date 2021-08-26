<?php
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/..');
function redirect(string $location) {
	header('HTTP/1.1 302');
	header("Location: $location");
}
?>

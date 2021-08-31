<?php
require_once 'base.php';
require_once 'csrf.php';
require_once 'user.php';
require_once 'alert.php';
require_once 'lang.php';
redirect('/');
if(isset($_GET['csrf']) && csrf_check($_GET['csrf'])) {
	session_start();
	unset($_SESSION['uid']);
	new Alert($__lang->translate('Logout.alert.success'), 'success');
} else
	new Alert($__lang->translate('alert.csrf'), 'danger');

<?php
require_once 'base.php';
require_once 'lang.php';
require_once 'csrf.php';
function show_page(?string $login = NULL) {
	global $__lang, $__title;
	$__title = $__lang->translate('Login.title');
	include 'header.php';
?>

<h1><?php tr('Login.header'); ?></h1>
<form action="/acc/login/" method="post">
	<div class="mb-3">
		<label for="loginInput" class="form-label"><?php tr('Login.login'); ?></label>
		<input id="loginInput" name="login" type="text" class="form-control"
	<?php if($login !== NULL) echo "value=\"$login\"" ?>
>
	</div>
	<div class="mb-3">
		<label for="passwordInput" class="form-label"><?php tr('Login.password'); ?></label>
		<input id="passwordInput" name="password" type="password" class="form-control">
	</div>
	<input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
	<button type="submit" class="btn btn-primary"><?php tr('Login.submit'); ?></button>
</form>

<?php
	include 'footer.php';
}

if($_SERVER['REQUEST_METHOD'] == 'GET') show_page();
else {
	require_once 'user.php';
	require_once 'alert.php';
	$correct = true;
	$login = $_POST['login'];
	$passwd = $_POST['password'];
	if(!is_string($login) || !is_string($passwd))
		die('wrong types of fields');
	if($login == '')
	{
		new Alert($__lang->translate('Login.alert.bad_login'), 'danger');
		$correct = false;
	}
	if($passwd == '')
	{
		new Alert($__lang->translate('Login.alert.bad_passwd'), 'danger');
		$correct = false;
	}
	if(!isset($_POST['csrf']) || !csrf_check($_POST['csrf'])) {
		new Alert($__lang->translate('alert.csrf'), 'danger');
		$correct = false;
	}

	if($correct) {
		if(User::login($login, $passwd) === NULL) {
			$correct = false;
			new Alert($__lang->translate('Login.alert.wrong'), 'danger');
		} else {
			new Alert($__lang->translate('Login.alert.success'), 'success');
			redirect(isset($_GET['next']) ? $_GET['next'] : '/');
		}
	}

	if(!$correct)
		show_page($login);
}
?>

<?php
require_once 'base.php';
require_once 'lang.php';
require_once 'csrf.php';
require_once 'alert.php';
require_once 'user.php';

function show_page(?string $login = NULL) {
	global $__lang, $__title;
	$__title = $__lang->translate('Register.title');
	include 'header.php';
?>

<h1><?php tr('Register.header'); ?></h1>
<form action="/acc/reg/" method="post">
	<div class="mb-3">
		<label for="loginInput" class="form-label"><?php tr('Register.login'); ?></label>
		<input id="loginInput" name="login" class="form-control"
			<?php if($login !== NULL) echo "value=\"$login\""; ?>>
	</div>
	<div class="mb-3">
		<label for="passwordInput" class="form-label"><?php tr('Register.password'); ?></label>
		<input id="passwordInput" name="password" type="password" class="form-control">
	</div>
	<div class="mb-3">
		<label for="password2Input" class="form-label"><?php tr('Register.password2'); ?></label>
		<input id="password2Input" name="password2" type="password" class="form-control">
	</div>
	<input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
	<button type="submit" class="btn btn-warning"><?php tr('Register.submit'); ?></button>
</form>

<?php
	include 'footer.php';
}

if($_SERVER['REQUEST_METHOD'] == 'GET')
	show_page();
elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
	$correct = true;
	if(!is_string($_POST['csrf']) || !csrf_check($_POST['csrf'])) {
		$correct = false;
		new Alert($__lang->translate('alert.csrf'), 'danger');
	}

	$login = trim($_POST['login']);
	$passwd = $_POST['password'];
	$passwd2 = $_POST['password2'];

	if(!preg_match('/^[0-9A-Za-z_-]{3,}$/', $login)) {
		$correct = false;
		new Alert($__lang->translate('Register.alert.bad_login'), 'danger');
	}
	if(strlen($passwd) < 5) {
		$correct = false;
		new Alert($__lang->translate('Register.alert.bad_passwd'), 'danger');
	}
	if($passwd !== $passwd2) {
		$correct = false;
		new Alert($__lang->translate('Register.alert.diff_passwd'), 'danger');
	}

	if($correct) {
		if(User::exists($login)) {
			$correct = false;
			new Alert($__lang->translate('Register.alert.user_exists'), 'danger');
		} elseif(User::register($login, $passwd)) {
			User::force_login($login);
			new Alert($__lang->translate('Register.alert.success'), 'success');
			redirect(isset($_GET['next']) ? $_GET['next'] : '/');
		}
	}
	if(!$correct)
		show_page($login);
}
?>

<?php
require_once 'lang.php';
require_once 'user.php';
require_once 'csrf.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
if(isset($__title))
	echo "<title>$__title</title>";
		?>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
	</head>
		<body lang="<?php echo $__lang->get_code(); ?>">
			<nav class="navbar navbar-expand-md navbar-light bg-light">
				<div class="container">
					<a class="navbar-brand" href="/"><?php tr('nav.title'); ?></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="langDropdownTg" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php tr('nav.lang'); ?></a>
								<ul class="dropdown-menu" aria-labelledby="langDropdownTg">
									<li><a class="dropdown-item" href="?lang=en">English</a></li>
									<li><a class="dropdown-item" href="?lang=ru">Русский</a></li>
								</ul>
							</li>
						</ul>
						<ul class="navbar-nav d-flex">

<?php
session_start();
if(isset($_SESSION['uid'])) {
?>

	<li class="nav-id"><?php echo User::get_name($_SESSION['uid']); ?> | <a href="/acc/logout.php?csrf=<?php echo csrf_token(); ?>"><?php tr('nav.logout'); ?></a></li>

<?php
} else {
?>

<li class="nav-item">
	<a class="btn btn-outline-success" href="/acc/login"><?php tr('nav.login'); ?></a>
</li>
<li class="nav-item">
	<a class="btn btn-warning" href="/acc/reg"><?php tr('nav.reg'); ?></a>
</li>

<?php } ?>

						</ul>
					</div>
				</div>
			</nav>
			<div id="alerts" class="container-sm">
<?php
	if(isset($_SESSION['alerts'])) {
		foreach($_SESSION['alerts'] as $al) {
			$al->print_html();
		}
		unset($_SESSION['alerts']);
	}
?>
			</div>
			<main class="container">

<?php
require_once 'lang.php';
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
					</div>
				</div>
			</nav>

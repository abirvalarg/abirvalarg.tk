<?php
class Alert {
	private string $message;
	private string $class;

	public function __construct(string $message, string $class = 'primary') {
		$this->message = $message;
		$this->class = $class;
		session_start();
		if(!isset($_SESSION['alerts']))
			$_SESSION['alerts'] = [];
		$_SESSION['alerts'][] = $this;
	}

	public function print_html() {
		?>
			<div class="alert alert-<?php echo $this->class; ?> alert-dismissible fade show" role="alert">
				<?php echo $this->message; ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php
	}
}
?>

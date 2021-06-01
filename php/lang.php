<?php
class Lang
{
	private static array $cache = [];
	private array $text;
	private bool $loaded = false;
	private string $code = '';

	function __construct(string $langName) {
		if(preg_match('/^[a-z]{2,3}$/', $langName)) {
			if(isset(self::$cache[$langName])) {
				$this->loaded = true;
				$this->text = self::$cache[$langName]->text;
			} else {
				$fp = fopen("/srv/http/abirvalarg.tk/lang/$langName.tr", 'r');
				if($fp) {
					$this->text = [];
					while(($line = fgets($fp)) !== false) {
						if($line[0] != '#') {
							$pair = explode('=', $line, 2);
							$this->text[$pair[0]] = $pair[1];
						}
					}
					$this->code = $langName;
					$this->loaded = true;
					self::$cache[$langName] = $this;
				}
			}
		}
	}

	public function is_loaded() : bool {
		return $this->loaded;
	}

	public function get_code() : string {
		return $this->code;
	}

	public function translate(string $id) : string {
		if(isset($this->text[$id]))
			return $this->text[$id];
		else
			return '{' . $id . '}';
	}

	public static function set_default(string $code) : bool {
		global $__lang;
		$l = new Lang($code);
		if($l->is_loaded()) {
			setcookie('lang', $code);
			$__lang = $l;
			return true;
		} else
			return false;
	}

	public static function auto() : void {
		foreach(explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $code) {
			$code = preg_split('/[-;]/', $code)[0];
			if(Lang::set_default($code))
				return;
		}
		Lang::set_default('en');
	}
};

function tr(string $id) : void {
	global $__lang;
	echo $__lang->translate($id);
}

if(isset($_GET['lang'])) {
	Lang::set_default($_GET['lang']);
} elseif(isset($_COOKIE['lang'])) {
	$__lang = new Lang($_COOKIE['lang']);
	if(!$__lang->is_loaded())
		Lang::auto();
} else {
	Lang::auto();
}
?>

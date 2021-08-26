<?php
require_once 'db.php';

class User {
	private static ?User $_cur = NULL;
	public ?int $uid = NULL;
	public ?string $login = NULL;
	public ?bool $isActive = NULL;
	public ?bool $isAdmin = NULL;
	public ?string $dispName = NULL;

	function __construct(int|string $uid) {
		$conn = db();
		switch(gettype($uid)) {
		case 'integer':
			$this->uid = $uid;
			$stmt = $conn->prepare('SELECT login, isActive, isAdmin, dispName FROM user WHERE id=?');
			$stmt->bind_param('i', $uid);
			break;

		case 'string':
			$this->login = $uid;
			$stmt = $conn->prepare('SELECT id, isActive, isAdmin, dispName FROM user WHERE login=?');
			$stmt->bind_param('s', $uid);
			break;
		}
		if($stmt->execute()) {
			$stmt->store_result();
			if($stmt->num_rows == 1) {
				$stmt->bind_result($idLogin, $this->isActive, $this->isAdmin, $this->dispName);
				$stmt->fetch();
				if($this->uid === NULL) $this->uid = $idLogin;
				else $this->login = $idLogin;
			} else $this->uid = $this->login = NULL;
		} else $this->uid = $this->login = NULL;
		$stmt->close();
	}

	public function save() : Bool {
		return false;
	}

	public static function login(string $login, string $password) : ?User {
		$result = NULL;
		$conn = db();
		$stmt = $conn->prepare('SELECT id, password FROM user WHERE login=?');
		$stmt->bind_param('s', $login);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows == 1) {
			$stmt->bind_result($uid, $passHash);
			$stmt->fetch();
			if(password_verify($password, $passHash)) {
				session_start();
				$_SESSION['uid'] = $uid;
				$result = new User($uid);
			}
		}
		$stmt->close();
		return $result;
	}

	public static function register(string $login, string $password) : Bool {
		$conn = db();
		$stmt = $conn->prepare('INSERT INTO user (login, password) VALUES (?, ?)');
		$passHash = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bind_param('ss', $login, $passHash);
		return $stmt->execute();
	}

	public static function exists(string $login) : Bool {
		$conn = db();
		$stmt = $conn->prepare('SELECT id FROM user WHERE login=?');
		$stmt->bind_param('s', $login);
		if($stmt->execute()) {
			$stmt->store_result();
			$result = $stmt->num_rows == 1;
		} else
			$result = false;
		$stmt->close();
		return $result;
	}

	public static function get_name(int $uid) : ?string {
		$result = NULL;
		$conn = db();
		$stmt = $conn->prepare('SELECT login, dispName FROM user WHERE id=?');
		$stmt->bind_param('i', $uid);
		if($stmt->execute()) {
			$stmt->store_result();
			if($stmt->num_rows == 1) {
				$login = NULL;
				$stmt->bind_result($login, $result);
				$stmt->fetch();
				if($result == NULL)
					$result = $login;
			}
		}
		$stmt->close();
		return $result;
	}

	public static function current() : ?User {
		session_start();
		if(User::$_cur && User::$_cur->uid == $_SESSION['uid'])
			return User::$_cur;
		elseif(!isset($_SESSION['uid'])) {
			User::$_cur = NULL;
			return NULL;
		} else {
			$user = new User($_SESSION['uid']);
			User::$_cur = $user;
			return $user;
		}
	}
};
?>

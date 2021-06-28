<?php
require_once 'db.php';

class User {
	public ?int $uid = NULL;
	public ?string $login = NULL;
	public bool $isActive = false;
	public bool $isAdmin = false;
	public ?string $dispName = NULL;

	function __construct($uid) {
		$conn = db();
		switch(gettype($uid)) {
		case 'integer':
			$this->uid = $uid;
			$stmt = $conn->prepare('SELECT login, isActive=\'Y\', isAdmin=\'Y\', dispName FROM user WHERE id=?');
			$stmt->bind_param('i', $uid);
			break;

		case 'string':
			$this->login = $uid;
			$stmt = $conn->prepare('SELECT id, isActive=\'Y\', isAdmin=\'Y\', dispName FROM user WHERE login=?');
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
		$stmt = db()->prepare('UPDATE user SET isActive=?, isAdmin=?, dispName=? WHERE id=?');
		$isActive = ($this->isActive ? 'Y' : 'N');
		$isAdmin = ($this->isAdmin ? 'Y' : 'N');
		$stmt->bind_param('sssi', $isActive, $isAdmin, $this->dispName, $this->uid);
		$res = $stmt->execute();
		$stmt->close();
		return $res;
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
			if(password_verify($password, $passHash)) $result = new User($uid);
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
};
?>

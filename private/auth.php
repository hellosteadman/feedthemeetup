<?php function protect() {
	if(!session_id()) {
		session_start();
	}
	
	$path = $_SERVER['REQUEST_URI'];
	if(!isset($_SESSION['user_id'])) {
		header('Location: /admin/login.php?next=' . urlencode($path) . '');
		die();
	}
}

function login() {
	$username = isset($_POST['username']) ? $_POST['username'] : null;
	$password = isset($_POST['password']) ? $_POST['password'] : null;
	
	if(!$username || !$password) {
		return false;
	}
	
	$password = md5($password);
	$statement = 'SELECT id FROM user WHERE username = :username AND password = :password';
	$login = sqlite_query($statement,
		array(
			'username' => $username,
			'password' => $password
		)
	);
	
	if(count($login) > 0) {
		if(!session_id()) {
			session_start();
		}
		
		$id = $login[0]['id'];
		$_SESSION['user_id'] = $id;
		return true;
	}
}
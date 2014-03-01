<?php require('partials/header.php');

if(session_id()) {
	if(isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);
	}
}

require('partials/footer.php');
header('Location: /');
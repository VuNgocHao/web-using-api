<?php
if (isset($_SESSION['username']) == false) {
	// Nếu người dùng chưa đăng nhập thì chuyển hướng website sang trang đăng nhập
	$login_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'index.php';
	header('Location:'.$login_url);
}else {
	if (isset($_SESSION['username']) == true) {
		
	}
}
?>
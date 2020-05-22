<?php
if (isset($_SESSION['username']) == false) {
	// Nếu người dùng chưa đăng nhập thì chuyển hướng website sang trang đăng nhập
	header('Location: http://localhost:8080/dynamic_web_usingapi/login.php');
}else {
	if (isset($_SESSION['username']) == true) {
		
	}
}
?>
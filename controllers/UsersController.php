<?php
if (isset($_POST['action'])){
    $action=$_POST['action'];
} else if (isset($_GET['action'])){
    $action=$_GET['action'];
} else {
    $action='';
}
$api_url = "https://web-api-test1.herokuapp.com/users";
switch ($action){
 case "logout":
    session_start();
    session_destroy();
    $login_url = './../login.php';
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $login_url;
    header('Location: ' . $home_url);
    break;
 case "login":
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $curl = curl_init();
        
    curl_setopt($curl, CURLOPT_HTTPGET, 1);

    curl_setopt($curl, CURLOPT_URL, $GLOBALS['api_url']);        
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $result = json_decode(curl_exec($curl));
    
    curl_close($curl);

    $flag = false;
    if (is_array($result) || is_object($result)){
        foreach($result as $user){
            if ($user->username==$username){
                if ($user->password==$password){
                    $flag = true;
                    break;
                }
            }
        }
    } else {
        echo "Kết nối api thất bại, vui lòng chờ server khởi động lại";
        exit();
    }
    if ($flag=="true"){
        session_start();
        $_SESSION['username'] = $username;
        echo "Đăng nhập thành công,$username";
    } else {
        echo "Đăng nhập ko thành công";
    }
    break;
 default:
    echo "K có quyền truy nhập";
    break;
}
?>
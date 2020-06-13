<?php

$api_url = "https://web-api-test1.herokuapp.com/users/all";

$login_path = './../index.php';
$users_view = "./../users_view.php";
$login_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $login_path;

$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $users_view;
if (isset($_POST['action'])){
    $action=$_POST['action'];
} else if (isset($_GET['action'])){
    $action=$_GET['action'];
} else {
    $action='';
}

switch ($action){
case "register":
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $data = array(
        "username"=>$username,
        "name"=>$name,
        "password"=>$password
    );
    $json = json_encode($data);
    $curl = curl_init();
    $url = 'https://web-api-test1.herokuapp.com/users';
    curl_setopt($curl,CURLOPT_URL,$url);
        
    curl_setopt($curl, CURLOPT_POST, 1);
        
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
        
    $result = curl_exec($curl);
    if (!$result){
        echo "Đăng kí thất bại, thử lại";
        exit;
    }
    $response = json_decode($result);
        
    curl_close($curl);
    if ($response->message=="Insert new user success!"){
        session_start();
        $_SESSION['username'] = $username; 
        header('Location: ' . $GLOBALS['home_url']);
    } else {
        echo "Đăng kí ko thành công.<a href='".$GLOBALS['login_url']."'>Quay lại </a>";
    }

    break;
 case "logout":
    session_start();
    session_destroy();
    header('Location: ' . $GLOBALS['login_url']);
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
        echo "Kết nối api thất bại, vui lòng chờ server khởi động lại. <a href='".$GLOBALS['login_url']."'>Quay lại</a>";
        exit();
    }
    if ($flag=="true"){
        session_start();
        $_SESSION['username'] = $username; 
        header('Location: ' . $GLOBALS['home_url']);
    } else {
        echo "Đăng nhập ko thành công.<a href='".$GLOBALS['login_url']."'>Quay lại </a>";
    }
    break;
//  default:
//     echo "K có quyền truy nhập";
//     break;
}
?>
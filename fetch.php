<?php
    session_start();
    include('permission.php');
    $api_url = "https://web-api-test1.herokuapp.com/users";
    $action = $_POST['action'];
    $method = $_SERVER['REQUEST_METHOD'];

    //$result = CallAPI($method,$url);
    switch ($action)
    {
        case "fetch_all_users":
            fetchAllUsers();
        break;
        case "create_new_user":
            $username = $_POST['create_username'];
            $name = $_POST['create_name'];
            $password = $_POST['create_password'];
            $data = array(
                "username"=>$username,
                "name"=>$name,
                "password"=>md5($password)
            );
            $json = json_encode($data);
            createNewUser($json);
        break;
        case "delete_user":
            $id = $_POST['id'];
            deleteUser($id);
        break;
        case "update_user":
            $id = $_POST['id'];
            $username = $_POST['edit_username'];
            $name = $_POST['edit_name'];
            $password = $_POST['edit_password'];
            if ($password!=''&&!is_empty($password)){
                $data = array(
                    "username"=>$username,
                    "name"=>$name,
                    "password"=>$password
                );
            } else {
                $data = array(
                    "username"=>$username,
                    "name"=>$name
                );
            }
            
            $json = json_encode($data);
            updateUser($id,$json);
        break;
    }
    function fetchAllUsers(){

        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_HTTPGET, 1);

        curl_setopt($curl, CURLOPT_URL, $GLOBALS['api_url']);        
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = json_decode(curl_exec($curl));
        
        curl_close($curl);

        $html = '';
        if (is_array($result) || is_object($result)){
            foreach($result as $user){
                $html .= '<tr>';
                $html .='<td>'.$user->id.'</td>
                        <td>'.$user->username.'</td>
                        <td>'.$user->name.'</td>
                        <td>
                            <button type="button" name="edit" class="btn btn-warning btn-xs edit" data-id="'.$user->id.'" data-username="'.$user->username.'" data-name="'.$user->name.'" data-toggle="modal" data-target="#editUserModal">Edit</button>
                            <button type="button" name="delete" class="btn btn-danger btn-xs delete" data-id="'.$user->id.'" onclick="deleteUserById();">Delete</button>
                        </td>';
                $html .= '</tr>';
            }
        } else {
            $html .="Refresh lại website,nếu k được vui lòng restart api hoặc fix code";
        }
        
        echo $html;
    }
    function createNewUser($json=''){
        $curl = curl_init();
        
        curl_setopt($curl,CURLOPT_URL,$GLOBALS['api_url']);
        
        curl_setopt($curl, CURLOPT_POST, 1);
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
         ));
        
         $result = curl_exec($curl);
        if (!$result){
            echo "Kết nối thất bại, thử lại";
            exit;
        }
         $response = json_decode($result);
        
         curl_close($curl);

        //echo $response;
    }
    function updateUser($id,$json=''){
        $api_url = $GLOBALS['api_url'].'/'.$id;
        
        $curl = curl_init();

        curl_setopt($curl,CURLOPT_URL,$api_url);
        
        curl_setopt($curl,CURL_CUSTOMREQUEST,"PUT");
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
         ));
        
         $result = curl_exec($curl);
        
         $response = json_decode($result);
        
         curl_close($curl);

        //echo $response;
    }
    function deleteUser($id,$json=''){
        
        $api_url = $GLOBALS['api_url'].'/'.$id; 
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $api_url);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($curl);
        
        $response = json_decode($result);

        curl_close($curl);
    
        //echo $response;
    }
    
?>
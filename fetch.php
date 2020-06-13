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
            $username = $_POST['username'];
            deleteUser($id,$username);
        break;
        case "update_user":
            $id = $_POST['id'];
            $username = $_POST['edit_username'];
            $name = $_POST['edit_name'];
            $password = $_POST['edit_password'];
            if ($password!=''){
                $data = array(
                    "username"=>$username,
                    "name"=>$name,
                    "password"=>md5($password)
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
        $page = $_POST['page'];
        $curl = curl_init();
        $api_url = $GLOBALS['api_url'].'?'.$page;
        curl_setopt($curl, CURLOPT_HTTPGET, 1);

        curl_setopt($curl, CURLOPT_URL, $api_url);        
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = json_decode(curl_exec($curl));
        
        curl_close($curl);

        $html = '';
        if (is_array($result) || is_object($result)){
            $list_user = $result->result;
            $pagination = $result->pagination;
            foreach($list_user as $user){
                $html .= '<tr>';
                $html .='<td>'.$user->id.'</td>
                        <td>'.$user->username.'</td>
                        <td>'.$user->name.'</td>
                        <td>
                            <button type="button" name="edit" class="btn btn-warning btn-xs edit" data-id="'.$user->id.'" data-username="'.$user->username.'" data-name="'.$user->name.'" data-toggle="modal" data-target="#editUserModal">Edit</button>
                            <button type="button" name="delete" class="btn btn-danger btn-xs delete" data-id="'.$user->id.'" data-username="'.$user->username.'" data-toggle="modal" data-target="#deleteUserModal">Delete</button>
                        </td>';
                $html .= '</tr>';
            }
            //phan trang
            $html .= '<tr colspan="4"><td></td><td></td><td><div class="pagination">';
            for ($i = 0;$i<$pagination->totalPage;$i++){
                $j = $i + 1;
                if ($i == $pagination->current) {
                    $html .= '<a class="active" href="users_view.php?page='.$i.'">'.$j;
                } else {
                    $html .= '<a href="users_view.php?page='.$i.'">'.$j;
                }
            }
            $html .='</div></td></tr>';

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
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
         ));
        //curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
        
         $result = curl_exec($curl);
        
         $response = json_decode($result);
        
         curl_close($curl);

        //echo $response;
    }
    function deleteUser($id,$json='',$username=''){
        
        $api_url = $GLOBALS['api_url'].'/'.$id; 
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $api_url);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($curl);
        
        $response = json_decode($result);
              
        curl_close($curl);

        if ($response->message=="Delete user success!" && $username==$_SESSION['username']){
            session_destroy();
            header('Location: ' . $GLOBALS['login_url']);
        }
    
        //echo $response;
    }
    
?>
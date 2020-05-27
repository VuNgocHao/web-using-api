<?php
  session_start();
  include("permission.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Danh sách tài khoản</title>
  </head>
  <body>
    <h1 align="center">Quản lý users</h1>
    <br>
    <h5 align="center">Chào mừng bạn, <?php echo $_SESSION['username']; ?></h5>
    <table class="table" style="margin-left:50px; margin-right:50px;width:90%">
        <thead class="thead-dark">
        <div  align="center" style="margin-bottom:10px">
          <button type="button" name="add_button" id="add_button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#createUserModal">Thêm</button>
          <a href="./controllers/UsersController.php?action=logout"><button type="button" name="logout_btn" id="logout_btn" class="btn btn-danger btn-lg">Đăng xuất</button></a>
        </div>
          
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Tên</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <div class="pagination">
      
      </div>
  <!-- edit Modal -->
  <form method="post" id="update_user_frm">
  <div class="modal fade" id="editUserModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Chỉnh sửa tài khoản</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_username">Username</label>
            <input type="text" class="form-control" name="edit_username" id="edit_username" aria-describedby="username" placeholder="Nhập username" value=" " oninvalid="alert('Chưa nhập username!')" required="required">
          </div>

          <div class="form-group">
            <label for="edit_name">Name</label>
            <input type="text" class="form-control" name="edit_name" id="edit_name" aria-describedby="name" placeholder="Nhập tên" value=" " oninvalid="alert('Chưa nhập tên!')" required="required">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name= "edit_password" id="edit_password" placeholder="Nhập mật khẩu" require>
          </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" value="update_user" name="action">
          <input type="hidden" value="1" name="id" id="edit_id">
          <button type="submit" class="btn btn-success" >Lưu thay đổi</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        </div>
      </div>
      </form>
    </div>
  </div> <!--add modal-->
  <!-- Modal -->
  <form method="post" id="insert_user_frm">
  <div class="modal fade" id="createUserModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Thêm tài khoản</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="create_username">Username</label>
            <input type="text" class="form-control" name="create_username" id="create_username" aria-describedby="username" placeholder="Nhập username" oninvalid="alert('Chưa nhập username!')" required="required">
          </div>

          <div class="form-group">
            <label for="create_name">Name</label>
            <input type="text" class="form-control" name="create_name" id="create_name" aria-describedby="name" placeholder="Nhập tên" oninvalid="alert('Chưa nhập tên!')" required="required">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name= "create_password" id="create_password" placeholder="Nhập mật khẩu" oninvalid="alert('Chưa nhập mật khẩu!')" required="required">
          </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" value="create_new_user" name="action">
          <button type="submit" class="btn btn-success" id="insert_btn_submit">Thêm mới</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        </div>
      </div>
      
    </div>
  </div>    
  </form><!--edit modal-->
  <!-- delete Modal -->
  <div class="modal fade" id="deleteUserModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">Xóa tài khoản</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc muốn xóa?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="delete_user_btn">Xóa</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
        </div>
      </div>
      
    </div>
  </div>    
<!--delete modal-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="052020.js"></script>  
  </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        fetch_data_users();
        $('#insert_user_frm').on('submit', function(event){
              event.preventDefault();
              var form_data = $('#insert_user_frm').serialize();
              $.ajax({
                      url:"fetch.php",
                      method:"POST",
                      data:form_data,
                      success:function(data)
                      {
                          fetch_data_users();
                          $('#insert_user_frm')[0].reset();
                          // $('#createUserModal').modal('hide');
                          alert("Đã thêm mới user!");
                      }
              });
        });
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id')
            var name = button.data('name') 
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-footer #edit_id').val(id);
            modal.find('.modal-body #edit_name').val(name);
            modal.find('.modal-body #edit_username').val(username);
        });

          $('#update_user_frm').on('submit', function(event){
              event.preventDefault();
              var form_data = $('#update_user_frm').serialize();
              var button = $(event.relatedTarget) 
              var id = $("#edit_id").val();
              $.ajax({
                      url:"fetch.php",
                      method:"POST",
                      //data:{id:id,form_data,action:"update_user"},
                      data:form_data,
                      success:function(data)
                      {
                          fetch_data_users();
                          alert("Đã cập nhật user!");
                          //$('#update_user_frm')[0].reset();
                      }
              });
          });
    })
    $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var username = button.data('username')
            $('#delete_user_btn').click(function(){
              
              var action = 'delete_user';
              $.ajax({
                  url:"fetch.php",
                  method:"POST",
                  data:{id:id, action:action,username:username},
                  success:function(data)
                  {
                      fetch_data_users();
                      alert("Đã xóa user!");
                      //$('#deleteUserModal').modal('hide');
                  }
              });
            });
            
        })
    
</script>

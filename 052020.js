function fetch_data_users(){
    $.ajax({
        url:"fetch.php",
        method:"POST",
        data:{action:'fetch_all_users'},
        success:function(data)
        {
            $('tbody').html(data);
        }
    })
}
function handle_insert_frm(){
        var form_data = $('#insert_user_frm').serialize();
        $.ajax({
                url:"fetch.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    fetch_data_users();
                    $('#insert_user_frm')[0].reset();
                    $('#createUserModal').modal('hide');
                    alert("Đã thêm mới user!");
                }
        });
}
// function deleteUserById(){
//     var button = $(event.relatedTarget) 
//     var id = button.data('id')
//     //var id = $('.delete').attr("data-id");
//     var action = 'delete_user';
//     if(confirm("Bạn chắc chắn muốn xóa?"))
//     {
//         $.ajax({
//             url:"fetch.php",
//             method:"POST",
//             data:{id:id, action:action},
//             success:function(data)
//             {
//                 fetch_data_users();
//                 alert("Đã xóa user!");
//             }
//         });
//     }
// }
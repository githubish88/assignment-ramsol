<!DOCTYPE html>
<html>
    <head>
        <title>Ishan-Assignment</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <style>
            .my-table{
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                border: 1px solid #ccc;
            }
            .new{
                margin-top: 4rem;
            }
            .my-actions{
                color: #007bff !important;
                text-decoration: underline !important;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="new">
                <button type="button" class="btn-success btn" id="newEntry">New</button>
            </div>
            <table class="table my-table mt-2">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">City</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="result">
                    
                </tbody>
            </table>

            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalTitle">New Entry</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form id="form-item" action="">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone:</label>
                                    <input type="number" class="form-control" id="phone" placeholder="Enter your phone number" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="city">City:</label>
                                    <input type="text" class="form-control" id="city" placeholder="Enter city name" name="city">
                                </div>
                            </form>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="onSubmit" action="new" for="" data-dismiss="modal">Save</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function(){

            // $('#myModal').on('shown.bs.modal', function () {
            //     $('#myInput').trigger('focus')
            // })
            readData();
            $("#newEntry").click(function() {
                $('#myModal').modal('toggle');
                $("#modalTitle").html('New Entry');
                $("#onSubmit").attr('action','new');
                $("#onSubmit").attr('for','');
                $("#form-item #name").val('');
                $("#form-item #email").val('');
                $("#form-item #phone").val('');
                $("#form-item #city").val('');
                $('#myModal').modal('show');
            });
            $("#onSubmit").click(function() {
                
                var name = $("#name").val();
                var email = $("#email").val();
                var phone = $("#phone").val();
                var city = $("#city").val();
                var type = $("#onSubmit").attr('action');
                var postData = {
                    'type': type, 
                    'name': name, 
                    'email': email, 
                    'phone': phone, 
                    'city': city
                };
                if(name != '' && email != '' && phone != '' && city != ''){
                    if(type == 'edit'){
                        var id = $("#onSubmit").attr('for');
                        postData.id = id;
                    }
                    $.ajax({
                        url: "form-submit.php", 
                        type: "POST", 
                        data: postData,
                        success: function(result){
                            readData();
                        }
                    });
                }
            });

            $(document).on('click','.action-edit', function(){
                var itemId = $(this).attr('item-id');
                $.ajax({
                    url: "read-by-id.php",
                    type: "POST", 
                    data: {'id': itemId},
                    success: function(result){
                        result = JSON.parse(result);
                        console.log(result);
                        $('#myModal').modal('toggle');
                        $("#modalTitle").html('Edit Item');
                        $("#onSubmit").attr('action','edit');
                        $("#onSubmit").attr('for', itemId);
                        $("#form-item #name").val(result.name);
                        $("#form-item #email").val(result.email);
                        $("#form-item #phone").val(result.phone);
                        $("#form-item #city").val(result.city);
                        $('#myModal').modal('show');
                    }
                });
            });
            $(document).on('click', '.action-delete', function(){
                var deleted = confirm('Are you sure?');
                if(deleted){
                    var itemId = $(this).attr('item-id');
                    $.ajax({
                        url: "delete.php",
                        type: "POST", 
                        data: {'id': itemId},
                        success: function(result){
                            readData();
                        }
                    });
                } else {
                    console.log('cancelled');
                }
            });
        });
        function readData(){
            var newRow = '';
            $.ajax({
                url: "read.php", 
                type: "POST", 
                data: {},
                success: function(result){
                    result = JSON.parse(result);
                    // console.log(result);
                    if(result && result.length > 0){
                        $.each(result, function(i, val){
                            var sl = Number(i + 1);
                            newRow += '<tr>'+
                                        '<th scope="row">'+ sl +'</th>'+
                                        '<td>'+ val.name +'</td>'+
                                        '<td>'+ val.email +'</td>'+
                                        '<td>'+ val.phone +'</td>'+
                                        '<td>'+ val.city +'</td>'+
                                        '<td>'+
                                            '<a class="my-actions action-edit" item-id="'+ val.id +'">Edit</a>'+
                                            '<a class="my-actions ml-2 action-delete" item-id="'+ val.id +'">Delete</a>'+
                                        '</td>'+
                                    '</tr>';
                            
                        });
                    }
                    else {
                        newRow += '<tr><td class="text-center" colspan="6">No results found</td></tr>';
                    }
                    $("#result").html(newRow);
                }
            });
        }
    </script>
</html>
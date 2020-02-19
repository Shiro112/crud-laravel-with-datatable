<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INV - PO</title>
    {{-- Yajra Style --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    {{-- Yajra JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br>
    <h3 class="text-center">Students</h3>
    <br>
    <div align="right">
        <button name="create-record" id="create-record" class="btn btn-success btn-sm" type="button">Add Record</button>
    </div>
    <br>
    <div class="table-responsive">
        <table id="user-table" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20%">Fist Name</th>
                    <th width="20%">Lat Name</th>
                    <th width="30%">Address</th>
                    <th width="25%">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add New Record</h4>
            </div>
            <div class="modal-body">
                <span id="form-alert"></span>
                <form method="post" id="sample-form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">First Name : </label>
                        <div class="col-md-8">
                            <input type="text" name="first_name" id="first_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Last Name : </label>
                        <div class="col-md-8">
                            <input type="text" name="last_name" id="last_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Address : </label>
                        <div class="col-md-8">
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" value="Add">
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 id="my-modal-title">Confirmation!!</h5>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure want to remove this data???</h4>
            </div>
            <div class="modal-footer">
                <button type="button" id="ok_button" name="ok_button" class="btn btn-danger">Ok</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
$(document).ready(function(){
    // Show data to Table
    $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('/student') }}"
        },
        columns: [
            {
            data: 'first_name',
            name: 'first_name'
            },
            {
            data: 'last_name',
            name: 'last_name'
            },
            {
            data: 'address',
            name: 'address'
            },
            {
            data: 'action',
            name: 'action',
            orderalbe: false
            }
        ]
    });

    // Show Modal
    $('#create-record').click(function(){
        $('#first_name').val('');
        $('#last_name').val('');
        $('#address').val('');
        $('#form-alert').html('');
        $('.modal-title').text('Add New record');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#formModal').modal('show');
    });

    // Insert Record
    $('#sample-form').on('submit', function(event){
        event.preventDefault();
        let action_url = '';
        if($('#action').val() == 'Add')
        {
            action_url = "{{ url('/student/create') }}";
        }
        if($('#action').val() == 'Edit')
        {
            action_url = "{{ url('/student/update') }}"
        }

        $.ajax({
            url: action_url,
            method: "post",
            data:$(this).serialize(),
            dataType: "json",

            success:function(data)
            {
                let html = '';
                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for (let count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>'+ data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample-form')[0].reset();
                    $('#user-table').DataTable().ajax.reload();
                }
                $('#form-alert').html(html);
                $('.alert.alert-success').hide(7000);
            }
        });
    });

    $(document).on('click', '.edit', function() {
        let id = $(this).attr('id');
        $('#form-alert').html('');
        $.ajax({
            url: '/student/'+id+'/edit',
            dataType: "json",
            success:function(data)
            {
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Edit');
                $('#action').val('Edit');
                $('#first_name').val(data.result.first_name);
                $('#last_name').val(data.result.last_name);
                $('#address').val(data.result.address);
                $('#hidden_id').val(id);
                $('#formModal').modal('show');
            }
        });
    });

    let user_id;
    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url: "/student/destroy/"+user_id,
            beforeSend:function(){
              $('#ok_button').text('Deleting......');
            },
            success:function()
            {
                setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#user-table').DataTable().ajax.reload();
                    alert('Data Deleted!!');
                }, 2000);
            }
        })
    });

});
</script>

</body>
</html>

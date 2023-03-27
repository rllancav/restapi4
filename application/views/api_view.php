<html>
<head>
    <title>CRUD REST API in Codeigniter</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Create CRUD REST API in Codeigniter - 4</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">CRUD REST API in Codeigniter</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Agregar</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="usuarioModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="usuario_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Usuario</h4>
                </div>
                <div class="modal-body">
                    <label>Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" />
                    <span id="nombre_error" class="text-danger"></span>
                    <br />
                    <label>Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" />
                    <span id="apellido_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="usuario_id" id="usuario_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
			
		
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#usuario_form')[0].reset();
        $('.modal-title').text("Agregar usuario");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#usuarioModal').modal('show');
    });

    $(document).on('submit', '#usuario_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'test_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#usuario_form')[0].reset();
                    $('#usuarioModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Registro Agregado</div>');
                    }
                }

                if(data.error)
                {
                    $('#nombre_error').html(data.nombre_error);
                    $('#apellido_error').html(data.apellido_error);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var usuario_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:{usuario_id:usuario_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {
                $('#usuarioModal').modal('show');
                $('#nombre').val(data.nombre);
                $('#apellido').val(data.apellido);
                $('.modal-title').text('Editar usuario');
                $('#usuario_id').val(usuario_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var usuario_id = $(this).attr('id');
        if(confirm("Esta Seguro de Eliminar ?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>test_api/action",
                method:"POST",
                data:{usuario_id:usuario_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Dato Eliminado</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
</script>
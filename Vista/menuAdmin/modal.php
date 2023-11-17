
<!-- Boton que activa modal -->
echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Usuario</button>';



<!-- HTML, el modal es esto -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role= "document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifique datos usuario</h5>
            </div>
            <div class="modal-body">
                <form id="actualizaUsuario" action="accionActualizarUsuario.php" class="needs-validation" method="POST">
                    <input type="hidden" name="idUsuario" id="idUsuario">
                    <input type="hidden" name="usPass" id="usPass">
                    <input type="hidden" name="usDeshabilitado" id="usDeshabilitado">
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Nombre Usuario</label>
                        <input type="text" name="usNombre" id="usNombre" class="form-control" placeholder="Ingrese nuevo nombre de usuario" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Mail Usuario</label>
                        <input type="email" name="usMail" id="usMail" class="form-control" placeholder="Ingrese nuevo mail del usuario" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="actualizaUsuario" name="insertData" class="btn btn-primary actualizar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- JS que activa la actualización y responde a la llamada -->
<?php
$(document).ready(function () {
    $('.editarBoton').on('click', function(){
        $('#exampleModal').modal('show');
            var tr = $(this).closest('tr');
            var data = tr.children("td").map(function(){
            return $(this).text();
        }).get();
        console.log(data);
        $('#idUsuario').val(data[0]);
        $('#usNombre').val(data[1]);
        /* $('#usPass').val(data[2]); */
        $('#usMail').val(data[2]);
        $('#usDeshabilitado').val(data[4]);
    });
});

$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarUsuario.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);
                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        registerSuccess();
                    }
                    else if (jsonData.success == "0") {
                        registerFailure();
                    }
                }
            });
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});
?>
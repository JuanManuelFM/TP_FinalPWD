function registerSuccessD() {
    Swal.fire({
        icon: 'success',
        title: 'El usuario se ha deshabilitado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function registerFailureD() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido deshabilitado el usuario!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function recargarPagina() {
    location.reload();
}

var cantidadBorrar;
$(document).on('click', '.remove', function () {

    var fila = $(this).closest('tr');
    console.log();
    $.ajax({
        type: "POST",
        url: 'accion/accionDeshabilitarUsuario.php',
        data: { idUsuario: fila[0].children[0].innerHTML},
        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);

            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccessD();
            }
            else if (jsonData.success == "0") {
                registerFailureD();
            }
        }
    });

});
function registerSuccessUnRemove() {
    Swal.fire({
        icon: 'success',
        title: 'El usuario se ha habilitado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function registerFailureUnRemove() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido habilitar el usuario!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

$(document).on('click', '.unRemove', function () {

    var fila = $(this).closest('tr');
    console.log();
    $.ajax({
        type: "POST",
        url: 'accion/accionHabilitarUsuario.php',
        data: { idUsuario: fila[0].children[0].innerHTML},
        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);

            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccessUnRemove();
            }
            else if (jsonData.success == "0") {
                registerFailureUnRemove();
            }
        }
    });

});
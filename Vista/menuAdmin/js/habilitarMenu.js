function registerSuccessUnRemove() {
    Swal.fire({
        icon: 'success',
        title: 'El menú se ha habilitado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    // setTimeout(function() {
    //     recargarPagina();
    // }, 1500);
}

function registerFailureUnRemove() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido habilitar el menú!',
        showConfirmButton: false,
        timer: 1500
    })
    // setTimeout(function() {
    //     recargarPagina();
    // }, 1500);
}

$(document).on('click', '.unRemove', function () {
    var fila = $(this).closest('tr');
    console.log(fila[0].children[0].id.substring(10));
    $.ajax({
        type: "POST",
        url: 'accion/accionHabilitarMenu.php',
        data: { idMenu: fila[0].children[0].id.substring(10) },
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
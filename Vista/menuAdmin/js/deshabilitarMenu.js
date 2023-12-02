function registerSuccessD() {
    Swal.fire({
        icon: 'success',
        title: 'El menú se ha deshabilitado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    // setTimeout(function() {
    //     recargarPagina();
    // }, 1500);
}

function registerFailureD() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido deshabilitar el menú!',
        showConfirmButton: false,
        timer: 1500
    })
    // setTimeout(function() {
    //     recargarPagina();
    // }, 1500);
}

function recargarPagina() {
    location.reload();
}

var cantidadBorrar;
$(document).on('click', '.remove', function() {
    var fila = $(this).closest('tr');
    // console.log(fila[0].children[0].id.substring(10));
    $.ajax({
        type: "POST",
        url: 'accion/accionDeshabilitarMenu.php',
        data: { idMenu: fila[0].children[0].id.substring(10) },
        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccessD();
            }
            else if (jsonData.success == "0") {
                console.log("falla");
                registerFailureD();
            }
        }
    });
});
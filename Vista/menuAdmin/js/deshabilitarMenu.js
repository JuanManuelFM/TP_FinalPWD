function registerSuccessD() {
    Swal.fire({
        icon: 'success',
        title: 'El menú se ha deshabilitado correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function() {
        recargarPagina();
    }, 1500);
}

function registerFailureD() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido deshabilitar el menú!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function() {
        recargarPagina();
    }, 1500);
}

function recargarPagina() {
    location.reload();
}

function handleClickDeshabilitar(idMenu) {
    console.log("holis");
    $.ajax({
        type: "POST",
        url: 'accion/accionDeshabilitarMenu.php',
        data: {
            idMenu
        },
        success: function(respuesta) {
            var jsonData = JSON.parse(respuesta);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccessD();
            } else if (jsonData.success == "0") {
                console.log("falla");
                registerFailureD();
            }
        }
    });
}
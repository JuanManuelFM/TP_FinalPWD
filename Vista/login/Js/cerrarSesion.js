function cerrarSesion() {
    $.ajax({
        type: "POST",
        url: '../login/accion/cerrarSesion.php',
        success: function (response) {
            var jsonData = JSON.parse(response);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                sesionCerrada();
            }
            else if (jsonData.success == "0") {
                sesionNoCerrada();
            }
        }
    });
}
function sesionCerrada(){
    Swal.fire({
        icon: 'success',
        title: 'Se cerró la sesión',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        window.location.href = "../paginaSegura/inicio.php";
    }, 1500);
}

function sesionNoCerrada(){
    Swal.fire({
        icon: 'error',
        title: 'No se cerró la sesión',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}
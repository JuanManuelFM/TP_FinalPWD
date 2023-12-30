$(document).ready(function() {
    $('.pagar').submit(function(e) {
        e.preventDefault();
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarCompraEstadoTipo.php',
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

function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La compra se realizó correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function() {
        recargarPagina();
    }, 1500);
}

function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'La compra no se pudo llevar a cabo correctamente!',
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
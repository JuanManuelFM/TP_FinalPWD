$(document).ready(function () {
    $('#form-crearProducto').submit(function (e) {
        e.preventDefault();
        // const forms = document.querySelectorAll('.needs-validation');
        // if (forms[0].checkValidity()) {
        /* $param['idProducto'],
                $param['proNombre'],
                $param['proDetalle'],
                $param['proCantStock'],
                $param['proPrecio'],
                $param['urlItem'] */
        $.ajax({
            type: "POST",
            url: 'accion/accionCrearProducto.php',
            data: {
                proNombre: document.getElementById('proNombre').value,
                proDetalle: document.getElementById('proDetalle').value,
                proCantStock: document.getElementById('proCantStock').value,
                proPrecio: document.getElementById('proPrecio').value,
                proUrlItem: document.getElementById('proUrlItem').value
            },
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
        // } else {
        // forms[0].classList.add('was-validated');
        // }
    });
});

function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'El producto se creó correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        recargarPagina();
    }, 1500);
}

function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'El producto no se pudo crear, intente nuevamente',
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
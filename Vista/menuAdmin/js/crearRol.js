$(document).on('click', '#boton_crearRol', function () {
    document.getElementById('crearRol').classList.remove('d-none');
});

$(document).on('click', '#boton_cancelar', function () {
    document.getElementById('crearRol').classList.add('d-none');
});

$(document).ready(function () {
    $('#form-crearRol').submit(function (e) {
        e.preventDefault();
        // const forms = document.querySelectorAll('.needs-validation');
        // if (forms[0].checkValidity()) {
        $.ajax({
            type: "POST",
            url: 'accion/accionCrearRol.php',
            data: {
                //Editar para usuario
                rolDescripcion: document.getElementById('rolDescripcion').value,
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
        title: 'El rol se creó correctamente!',
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
        title: 'El rol no se pudo crear, intente nuevamente',
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
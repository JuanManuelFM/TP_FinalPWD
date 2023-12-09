$(document).on('click', '#boton_crearMenu', function() {
    document.getElementById('crearMenu').classList.remove('d-none');
});

$(document).on('click', '#boton_cancelar', function() {
    document.getElementById('crearMenu').classList.add('d-none');
});

$(document).ready(function() {
    $('#form-crearMenu').submit(function(e) {
        e.preventDefault();
        // const forms = document.querySelectorAll('.needs-validation');
        // if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionCrearMenu.php',
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
        // } else {
            // forms[0].classList.add('was-validated');
        // }
    });
});

function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'El menú se creó correctamente!',
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
        title: 'El menú no se pudo crear, intente de nuevo',
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
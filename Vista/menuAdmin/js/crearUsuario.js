$(document).on('click', '#boton_crearUsuario', function () {
    document.getElementById('crearUsuario').classList.remove('d-none');
});

$(document).on('click', '#boton_cancelar', function () {
    document.getElementById('crearUsuario').classList.add('d-none');
});

$(document).ready(function () {
    $('#form-crearUsuario').submit(function (e) {
        e.preventDefault();
        // const forms = document.querySelectorAll('.needs-validation');
        // if (forms[0].checkValidity()) {
        let idRol = 0;
        let i = 1;
        do {
            idRol = document.getElementById(`flexRadioDefault${i}`).checked ? Number(document.getElementById(`flexRadioDefault${i}`).value) : 0;
            i++;
        } while (idRol === 0 && i <= 3);

        $.ajax({
            type: "POST",
            url: 'accion/accionCrearUsuario.php',
            data: {
                //Editar para usuario
                usNombre: document.getElementById('usNombre').value,
                usPass: document.getElementById('usPass').value,
                usMail: document.getElementById('usMail').value,
                idRol
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
        title: 'El usuario se creó correctamente!',
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
        title: 'El usuario no se pudo crear, intente nuevamente',
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
$(document).on('click', '#boton_editarDatos', function() {
    document.getElementById('editarDatos').classList.remove('d-none');
    document.getElementById('editarContraseña').classList.add('d-none');
});

$(document).on('click', '#boton_contra', function() {
    document.getElementById('editarDatos').classList.add('d-none');
    document.getElementById('editarContraseña').classList.remove('d-none');
});


$(document).on('click', '#boton_cancelar', function() {
    document.getElementById('editarDatos').classList.add('d-none');
    document.getElementById('editarContraseña').classList.add('d-none');
});

$(document).ready(function () {
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarPerfil.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    if (jsonData.success == "1") {
                        window.location.reload();
                        success();
                    }
                    else if (jsonData.success == "0") {
                        failure();
                    }
                }
            });
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});

$(document).ready(function () {
    $('#form-contraseña').submit(function(e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        var passActual = document.getElementById('usPassVieja').value;
        // passActual = hex_md5(passActual).toString();
        var passSesion = document.getElementById('usPassSesion').value;
        // if(passActual == passSesion){ 
        // var passhash = hex_md5(password).toString();
        $.ajax({
            type: "POST",
            url: 'accion/accionActualizarPerfil.php',
            data: $(this).serialize(),
            success: function (response) {
                var jsonData = JSON.parse(response);
                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1") {
                    contraSucces();
                    forms[1].reset();
                }
                else if (jsonData.success == "0") {
                    contraFailure(jsonData.message);
                }
            }
        });
    });
});

function success() {
    Swal.fire({
        icon: 'success',
        title: 'Tu email se ha modificado!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.reload();
    }, 1500);
}

function failure() {
    Swal.fire({
        icon: 'error',
        title: 'No se ha podido modificar el email!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.reload();
    }, 1500);
}

function failureContra() {
    Swal.fire({
        icon: 'error',
        title: 'La contraseña no coincide con la actual!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
    }, 1500);
}

function contraFailure(message) {
    Swal.fire({
        icon: 'error',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.reload();
    }, 1500);
}

function contraSucces() {
    Swal.fire({
        icon: 'success',
        title: 'Se ha modificado la contraseña!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.reload();
    }, 1500);
}
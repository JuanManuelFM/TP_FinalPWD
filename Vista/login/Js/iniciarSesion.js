function redireccionarPaginaInicio() {
    location.href = '../paginaSegura/inicio.php'
}
function redireccionarInicioSesion() {
    location.href = 'login.php'
}
$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            let password = document.getElementById("usPassVisible").value;
            let passhash = hex_md5(password).toString();
            document.getElementById("usPass").value = passhash;
            $.ajax({
                type: "POST",
                url: '../accion/verificarLogin.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        loginSuccess();
                    }
                    else if (jsonData.success == "0") {
                        loginFailure();
                    }
                }
            });
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});


function loginSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La sesión se inició correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        window.location.href = "../paginaSegura/inicio.php";
    }, 1500);
}

function loginFailure() {
    Swal.fire({
        icon: 'error',
        title: 'La contraseña y/o el usuario no coinciden!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        location.reload();
    }, 1500);
}

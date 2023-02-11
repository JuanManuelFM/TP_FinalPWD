$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            if(document.getElementById('usPass').value == document.getElementById('usPassRep').value){
            var password = document.getElementById("usPass").value;
            var passhash = hex_md5(password).toString();
            document.getElementById("usPass").value = passhash;
            $.ajax({
                type: "POST",
                url: 'accion/accionAjaxRegistro.php',
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
                document.getElementsByClassName('invalid-password')[0].style = "display: block; color:red";
                document.getElementsByClassName('invalid-password')[1].style = "display: block; color:red";
            }
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});


function registerSuccess() {
    Swal.fire({
        icon: 'success',
        title: 'La cuenta se creo correctamente!',
        showConfirmButton: false,
        timer: 1500
    })
    setTimeout(function () {
        window.location.href = "../paginaSegura/inicio.php";
    }, 1500);
}

function registerFailure() {
    Swal.fire({
        icon: 'error',
        title: 'La cuenta no se pudo crear en la base de datos!',
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
$(document).ready(function () {
    $('.editarBoton').on('click', function(){
       
        $('#exampleModal').modal('show');
        
            var tr = $(this).closest('tr');
            var data = tr.children("td").map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#idUsuario').val(data[0]);
        $('#usNombre').val(data[1]);
        /* $('#usPass').val(data[2]); */
        $('#usMail').val(data[2]);
        $('#usDeshabilitado').val(data[4]);
    });
});

$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarUsuario.php',
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
        title: 'La cuenta se editó correctamente!',
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
        title: 'La cuenta no se pudo editar en la base de datos!',
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
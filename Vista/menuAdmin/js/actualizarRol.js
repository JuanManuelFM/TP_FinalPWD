$(document).ready(function() {
    $('.editarBoton').on('click', function() {
        $('#exampleModal').modal('show');
        var tr = $(this).closest('tr');
        var data = tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#idRol').val(data[0]);
        $('#rolDescripcion').val(data[1]);
    });
});

$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarRol.php',
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
        title: 'El rol se editó correctamente!',
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
        title: 'El rol no se pudo editar en la base de datos!',
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
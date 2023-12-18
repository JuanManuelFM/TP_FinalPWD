// $(document).ready(function() {
//     $('.editarBoton').on('click', function() {
//         $('#exampleModal').modal('show');
//         var tr = $(this).closest('tr');
//         var data = tr.children("td").map(function() {
//             return $(this).text();
//         }).get();

//         $('#idMenu').val(data[0]);
//         $('#meDescripcion').val(data[1]);
//         /* $('#padre').val(data[2]); */
//         $('#meDeshabilitado').val(data[3]);
//     });
// });

$(document).ready(function() {
    $('#actualizarMenu').submit(function(e) {
        e.preventDefault();
        // const forms = document.querySelectorAll('.needs-validation');
        // if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarMenu.php',
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
        title: 'El menú se editó correctamente!',
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
        title: 'El menú no se pudo editar en la base de datos!',
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
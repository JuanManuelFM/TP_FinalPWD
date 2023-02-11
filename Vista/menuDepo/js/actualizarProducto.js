$(document).ready(function () {
    $('.editarBoton').on('click', function(){
       
        $('#exampleModal').modal('show');
        
            var tr = $(this).closest('tr');
            var data = tr.children("td").map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#urlImagen').val(data[0]);
        $('#urlItem').val(data[1]);
        $('#idProducto').val(data[2]);
        $('#proNombre').val(data[3]);
        $('#proDetalle').val(data[4]);
        $('#proPrecio').val(data[5]);
        $('#proCantStock').val(data[6]);
    });
});

$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'accion/accionActualizarProducto.php',
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
        title: 'El producto se editó correctamente!',
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
        title: 'El producto no se pudo editar en la base de datos!',
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
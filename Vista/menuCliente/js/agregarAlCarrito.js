$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        const forms = document.querySelectorAll('.needs-validation');
        if (forms[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: 'Accion/accionAgregarAlCarrito.php',
                data: $(this).serialize(),
                success: function (response) {
                    var jsonData = JSON.parse(response);

                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        cargaExitosa();
                        recargarPagina();
                    }
                    else if (jsonData.success == "0") {
                        cargaFallida();
                        recargarPagina();
                    }
                }
            });
            recargarPagina();
        } else {
            forms[0].classList.add('was-validated');
        }
    });
});


function cargaExitosa() {
    alert("se ah añadido");
}

function cargaFallida() {
    alert("no se pudo agregar")
}

function recargarPagina() {
    location.reload();
}
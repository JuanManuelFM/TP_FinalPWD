$(document).ready(function () {
    $(".Eliminar").submit(function (e) {
      e.preventDefault();
      const forms = document.querySelectorAll(".needs-validation");
      // if (e.checkValidity()) {
      $.ajax({
        type: "POST",
        url: "accion/eliminarDeCarrito.php",
        data: $(this).serialize(),
        success: function (response) {
          var jsonData = JSON.parse(response);
          // user is logged in successfully in the back-end
          // let's redirect
          if (jsonData.success == "1") {
            cargaExitosa(jsonData.message);
          } else if (jsonData.success == "0") {
            cargaFallida(jsonData.message);
          }
        },
      });
      // } else {
      // forms[0].classList.add("was-validated");
      // }
    });
  });
  
  function cargaExitosa(message) {
    alert(message);
    recargarPagina();
  }
  
  function cargaFallida(message) {
    alert(message);
    recargarPagina();
  }
  
  function recargarPagina() {
    location.reload();
  }
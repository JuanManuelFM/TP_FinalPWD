<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
if($objSession->getVista() != null && $objSession->getVista() == 3) {
?>
<div class="container mt-5 mb-5 mt-5">
    <form class="needs-validation" novalidate>
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label for="validationCustom01">Nombre producto</label>
          <input type="text" class="form-control" id="validationCustom01" placeholder="Nombre Artículo" required>
          <div class="valid-feedback">
            Perfecto!
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationCustom02">Unidades en stock</label>
          <input type="number" class="form-control" id="validationCustom02" placeholder="0" required>
          <div class="valid-feedback">
            Perfecto!
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationCustom05">Precio</label>
          <input type="number" class="form-control" placeholder="0" id="validationCustom05" required>
          <div class="invalid-feedback">
            No vendemos objetos con precios menores a $1000 pesos.
          </div>
        </div>
            <div class="col-md-4 mb-3">
            <label for="validationCustom01">Descripción producto</label>
            <input type="text" class="form-control" id="validationCustom01" placeholder="Detalles" required>
            <div class="valid-feedback">
            Perfecto!
            </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="validationCustom03">Link de imagen</label>
          <input type="text" class="form-control" id="validationCustom03" required>
          <div class="invalid-feedback">
            Por favor ingrese un link válido!.
          </div>
        </div>
      </div>
      <button class="btn btn-primary" type="submit">Subir producto</button>
    </form>
</div>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
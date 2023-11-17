<?php
include_once("../../configuracion.php");
include_once("../menu/cabecera.php");
if($objSession->getVista()!= null && $objSession->getVista() == 2){
?>
<div class="col-12 col-sm-12 col-md-4 col-lg-3 container py-2">
  <div class="caja_producto container col-9 col-sm-12 col-md-12 py-2">
    <div class="img_productos">
      <img src="<?php $objProducto->getUrlItem() ?>" class="img-thumbnail rounded col-8 col-md-11 col-sm-9" style="width: auto;height: 260px">
    </div>
    <div class="titulo_producto text-center">
      <h6 style="display: inline-block;"><?php $objProducto->getProNombre() - $objProducto->getProPrecio() ?></h6>
    </div>
    <form action="accion/accionAgregarAlCarrito.php" method="post" class="needs-validation Comprar" novalidate>
      <input type="text" name="idProducto" id="idProducto" class="d-none" value="<?php $objProducto->getIdProducto() ?>">
      <div class='container-fluid'>
        <div class='col-4 d-inline-block'>
          <input type="number" value='1' name="ciCantidad" id="cantidad_input" min="1" max="<?php $objProducto->getProCantStock() ?>" class="form-control col-sm-2" placeholder="cant" required cols="2" width='60px'>
          <div class="invalid-feedback mb-1">
            sin stock
          </div>
          <div class="valid-feedback mb-1">
            bien!
          </div>
        </div>
        <input class="btn btn-success me-2" type="submit" name="boton_enviar" value="comprar" onclick='location.reload();'>
        </br>
        stock: <?php echo $stock = $objProducto->getProCantStock() ?>
      </div>
      <div class="d-none"><?php echo $objProducto->getIdProducto() ?></div>
    </form>
    <hr>
    <div class="desc_producto"><?php echo $objProducto->getProDetalle() ?></div>
  </div>
</div>
<form action="../accion/comprar.php"></form>

<!-- boton carrito -->
<div class="col-12 d-flex align-items-center" style="align-items: end; padding-right: 30px; margin-top: 10px; margin-bottom: 10px; justify-content: space-between; text-align: center;">
  <h1>CARRITO</h1>
  <button type="button" class="" data-bs-toggle="modal" data-bs-target="#CARRITO_MODAL">
    <img src="css/img/carrito.png" alt="" srcset="" width="60px">
  </button>
</div>
<div class="container-fluid">
  <div class="row" id="tienda_productos">
    <?php crearTienda() ?>
  </div>
</div>

<div class="modal fade" id="CARRITO_MODAL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog col-11" style="max-width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">carrito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container align-items-center " style="margin-top: 50px;">
          <table class="table table-hover table-bordered">
            <thead class="">
              <thead class="table-dark">
                <th colspan="3" scope="col" id="nombreCliente">usuario</td>
                <th colspan="3" scope="col">botones</td>
              </thead>
            </thead>
            <tbody>
              <tr class="table-primary">
                <th scope="col">id_p</th>
                <th scope="col">nombre_producto</th>
                <th scope="col">foto_prod</th>
                <th scope="col">descripcion_prod</th>
                <th scope="col">cant</th>
                <th scope="col">acciones_cli</th>
              </tr>
              <div>
                <?php
                $controlCompraItem->crearCarrito($idUsuario);
                ?>
              </div>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-primary">ACEPTAR</button>
      </div>
    </div>
  </div>
</div>
<!-- </body> -->

<script>
  (function() {
    'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>
<script src="js/comprar.js"></script>
<script src="js/eliminarDeCarritoPrueba.js"></script>
<link rel="stylesheet" href="css/tienda.css">

<!-- </html> -->
<?php
}else{
  header('Location: ../../index.php');
} 
include_once("../menu/pie.php") //holahhj
?>
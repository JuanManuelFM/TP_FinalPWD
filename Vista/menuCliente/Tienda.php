<?php
include_once("../../configuracion.php");
include_once("../menu/cabecera.php");
if ($objSession->getVista() != null && $objSession->getVista() == 2) {
    $productoController = new c_producto();
    $productos = $productoController->buscar(null);
    $controlCompraItem = new c_compraItem();
    $compra_array= $controlCompraItem->carritoIniciado($objSession->getUsuario()->getIdUsuario());
    //si no hay compra, no entra a la ternaria y no genera un error
    if(count($compra_array) > 0){
        $compra = $compra_array[0];
    }
?>
    <div class="w-100 row px-3">
        <?php
        foreach ($productos as $objProducto) {
        ?>
            <div class="my-1 p-1 col-4">
                <div class="caja_producto text-white" style="background-color: rgba(0,0,0,.5);">
                    <div class="img_productos">
                        <img src="<?= $objProducto->getUrlItem() ?>" class="img-thumbnail" style="width: auto;height: 260px">
                    </div>
                    <div class="titulo_producto text-center">
                        <h6 style="display: inline-block;">
                            <?= $objProducto->getProNombre() . " - $" .  $objProducto->getProPrecio() ?></h6>
                    </div>
                    <form action="./accion/accionAgregarAlCarrito.php" method="POST" class="needs-validation Comprar" novalidate>
                        <input type="text" id="idUsuario" name="idUsuario" value="<?= $objSession->getUsuario()->getIdUsuario() ?>" hidden>
                        <input type="text" name="idProducto" id="idProducto" class="d-none" value="<?= $objProducto->getIdProducto() ?>">
                        <div class='container-fluid'>
                            <div class='d-inline-block'>
                                <input type="number" value='0' name="ciCantidad" id="cantidad_input" min="1" max="<?= $objProducto->getProCantStock() ?>" class="form-control col-sm-2" placeholder="cant" required cols="2" width='60px' <?= $objProducto->getProCantStock() > 0 ? "" : "disabled" ?>>
                            </div>
                            <input class="btn btn-success me-2" type="submit" name="boton_enviar" value="comprar" <?= $objProducto->getProCantStock() > 0 ? "" : "disabled" ?>>
                            </br>
                            <span id="stock<?= $objProducto->getidProducto ?>">
                                Stock: <?php echo $stock = $objProducto->getProCantStock() ?>
                            </span>
                        </div>
                    </form>
                    <hr>
                    <div class="desc_producto"><span class="text-decoration-underline">Detalle:</span>
                        <?php echo $objProducto->getProDetalle() ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- <form action="../accion/comprar.php"></form> -->

    <!-- boton carrito -->
    <div class="col-12 d-flex align-items-center" style="align-items: end; padding-right: 30px; margin-top: 10px; margin-bottom: 10px; justify-content: space-between; text-align: center;">
        <h1>CARRITO</h1>
        <button type="button" class="" data-bs-toggle="modal" data-bs-target="#CARRITO_MODAL">
            <img src="css/img/carrito.png" alt="" srcset="" width="60px">
        </button>
    </div>
    <div class="container-fluid">
        <div class="row" id="tienda_productos">
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre Producto</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col"></th>
                                </tr>
                                <div>
                                    <?php
                                    echo $controlCompraItem->crearCarrito($objSession->getUsuario()->getIdUsuario());
                                    ?>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <!-- TERNARIA php: ((CONDICION) ? AFIRMACION : NEGACION) isset se fija si la condicion o variable existe -->
                    <a href="pago.php?compra=<?=
                    ((isset($compra)) ? $compra->getObjCompra()->getIdCompra():null)?>"><button type="button" class="btn btn-primary"> COMPRAR </button></a>
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
            // Array.prototype.slice.call(forms)
            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    // if (!form.checkValidity()) {
                    //     event.preventDefault()
                    //     event.stopPropagation()
                    // }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script src="js/comprar.js"></script>
    <script src="js/eliminarDeCarrito.js"></script>
    <link rel="stylesheet" href="css/tienda.css">

    <!-- </html> -->
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php") //holahhj
?>
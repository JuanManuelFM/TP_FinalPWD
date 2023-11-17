<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$objProducto = new c_producto();
$arrayProductos = $objProducto->buscar(null);
if($objSession->getVista() != null && $objSession->getVista() == 3) {
    if ($arrayProductos != null) {
        $cantProductos = count($arrayProductos);
    } else {
        $cantProductos = -1;
    }
    $i = 0;
    ?>
<div class="container col-md-10">
</div>
<div class="container-fluid">
    <div class="container col-md-10">
        <br>
        <h2>Lista de todos los productos de la plataforma</h2>
        <div class="mb-3">
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th>Imagen</th>
                        <th>ID producto</th>
                        <th>Nombre</th>
                        <th>Detalle</th>
                        <th>Precio</th>
                        <th>En stock</th>
                        <th>Editar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($arrayProductos)) { //isset se fija si la variable tiene algo
                            foreach ($arrayProductos as $producto) {
                                echo '<tr>';
                                echo '<td><img src="' . $producto->getUrlItem() . '" alt="" height="100" width="100"></td>';
                                echo '<td style= display:none;>' . $producto->getUrlItem() . '</td>';
                                echo '<td>' . $producto->getIdProducto() . '</td>';
                                echo '<td>' . $producto->getProNombre() . '</td>';
                                echo '<td>' . $producto->getProDetalle() . '</td>';
                                echo '<td>' . $producto->getProPrecio() . '</td>';
                                echo '<td>' . $producto->getProCantStock() . '</td>';
                                echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Producto</button>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<p class="lead"> Actualmente no hay productos registrados </p>';
                        }
    ?>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifique datos producto</h5>
                </div>
                <form action="accionActualizarProducto.php" class="needs-validation" method="POST">

                    <div class="modal-body">
                        <input type="hidden" name="urlImagen" id="urlImagen">
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>URL Imagen</label>
                            <input type="url" name="urlItem" id="urlItem" class="form-control" placeholder="Ingrese nuevo URL de la nueva imagen" required>
                        </div>
                        <input type="hidden" name="idProducto" id="idProducto">
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>Nombre Producto</label>
                            <input type="text" name="proNombre" id="proNombre" class="form-control" placeholder="Ingrese nuevo nombre de producto" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>Detalles</label>
                            <input type="text" name="proDetalle" id="proDetalle" class="form-control" placeholder="Ingrese nuevo detalle de producto" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>Precio</label>
                            <input type="number" name="proPrecio" id="proPrecio" class="form-control" placeholder="Ingrese nuevo precio de producto" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>Stock</label>
                            <input type="number" name="proCantStock" id="proCantStock" class="form-control" placeholder="Ingrese stock disponible de producto" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="insertData" class="btn btn-primary actualizar">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            </tbody>
            </table>
        </div>
    </div>
</div>
<!-- </body> -->
<script src="js/deshabilitarUsuario.js"></script>
<script src="js/habilitarUsuario.js"></script>
<script src="js/actualizarProducto.js"></script>
<!-- </html> -->
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
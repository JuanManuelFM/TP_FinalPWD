<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$controllerCompra = new c_compra();
$arrayCompras = $controllerCompra->listar('');

$controllerCompraEstado = new c_compraEstado();
$controllerCompraEstadoTipo = new c_compraEstadoTipo();

$controllerCompraItem = new c_compraItem();

if($objSession->getVista() != null && $objSession->getVista() == 3) {
    if ($arrayCompras != null) {

        foreach($arrayCompras as $compra){
            $arrayComprasEstado = $controllerCompraEstado->buscar(['idCompra' => $compra->getIdCompra()]);
            $arrayEstado = $controllerCompraEstadoTipo->buscar(['idCompraEstadoTipo' => $arrayComprasEstado[0]->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()]);
?>
<div class="container col-md-10">
</div>
<div class="container-fluid">
    <div class="container col-md-10">
        <br>
        <h2>Compra Nro <?php echo $compra->getIdCompra() ?></h2>
        <h2>Usuario <?php echo $compra->getObjUsuario()->getUsNombre(); ?></h2>
        <h2>Estado <?php echo $arrayEstado[0]->getCetDescripcion(); ?></h2>
        <h2>Fecha inicio <?php echo $compra->getCoFecha() ?></h2>
        <h2>Fecha fin <?php echo $compra->getIdCompra() ?></h2>
        <h2> Listado de productos de compra: </h2>
        <form id="compraEnviada">
            <input name="idCompra" type="hidden" value="<?php echo $compra->getIdCompra() ?>">
            <button type="submit">Enviada</button> <!-- EL FORMA RAPIDA DE REALIZAR DOS ACCIONES DE COMPRA SENCILLAS -->
        </form>
        <form id="compraCancelada">
        <input name="idCompra" type="hidden" value="<?php echo $compra->getIdCompra() ?>">
            <button type="submit">Cancelada</button>
       </form>
        <div class="mb-3">
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th>ID Producto</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Total</th> <!-- TOTAL DE PRODUCTO MULTIPLICADO POR LA CANTIDAD DEL PRODUCTO -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                   
                        $productos_compra = $controllerCompraItem->buscar(['idCompra' => $compra->getIdCompra()]);

                        $objProducto = new c_producto();
        
                        if (isset($productos_compra)) {
                            foreach ($productos_compra as $producto) {
                                $objProducto = $producto->getObjProducto();
                                echo '<tr class="align-middle text-center">';
                        
                                echo '<td>' . $objProducto->getIdProducto() . '</td>';
                                echo '<td><img src="' . $objProducto->getUrlItem() . '" alt="" height="100" width="100"></td>';
                                echo '<td>' . $objProducto->getProNombre() . '</td>';
                                echo '<td>' . $producto->getCiCantidad() . '</td>';
                                echo '<td>' . ($objProducto->getProPrecio()*$producto->getCiCantidad()) . '</td>';

                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/actualizarCompraEstadoTipo.js"></script>
<?php
        }
    }
}
if ($arrayCompras == null) {
    echo "<h2 class='text-warning text-center' style='margin-bottom: 20%;margin-top:5%'> Todavia nadie creo compras! </h2>";
}

include_once("../menu/pie.php");
?>
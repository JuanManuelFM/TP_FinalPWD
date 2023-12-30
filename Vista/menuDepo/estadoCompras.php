<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$controllerCompra = new c_compra();
$controllerCompraEstado = new c_compraEstado();
$controllerCompraEstadoTipo = new c_compraEstadoTipo();
$controllerCompraItem = new c_compraItem();

if($objSession->getVista() != null && $objSession->getVista() == 3) {
    $arrayCompras = $controllerCompra->buscar();
    if ($arrayCompras != null) {
        $arrayComprasRealiazadas = $controllerCompraEstado->// buscarCompraEstadoNull/buscarCompraEstadoIniciada($arrayCompra);
        if (count($arrayComprasRealiazadas) > 0) {
?>
<div class="container col-md-10">
</div>
<div class="container-fluid">
    <div class="container col-md-10">
        <br>
        <h2>Lista de todas las compras realizadas en la plataforma</h2>
        <div class="mb-3">
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th>ID compra</th>
                        <th>ID Producto</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>ID Usuario</th>
                        <th>Estado</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        /* <td>' . $compraRealizada->getCompra()->getIdCompra() . '</td>
                        <td>' . $compraRealizada->getCompra()->getObjUsuario()->getUsNombre() . '</td>
                        <td>' . $compraRealizada->getCompraEstadoTipo()->getCetDescripcion() . '</td> */

                        if (isset($arrayComprasRealiazadas)) { //isset se fija si la variable tiene algo
                            foreach ($arrayComprasRealiazadas as $compraRealizada) {
                                echo '<tr class="align-middle text-center">';
                                echo '<td>' . $compraRealizada->getIdCompra() . '</td>';
                                // mas cosas aaaaaaa
                                echo '<td>' . $compraRealizada->getCeFechaIni() . '</td>';
                                echo '<td>' . $compraRealizada->getCeFechaFin() . '</td>';
                                /* echo '<td>' . $producto->getProNombre() . '</td>';
                                echo '<td>' . $producto->getProDetalle() . '</td>';
                                echo '<td>' . $producto->getProPrecio() . '</td>';
                                echo '<td>' . $producto->getProCantStock() . '</td>'; */
                                echo '</tr>';
                            }
                        } else {
                            echo '<p class="lead"> Actualmente no hay productos registrados </p>';
                        }
    ?>
        </div>
    </div>
</div>
<?php
    }
}
if ($arrayCompras == null || count($arrayComprasRealiazadas) == 0) {
    echo "<h2 class='text-warning text-center' style='margin-bottom: 20%;margin-top:5%'> Todavia nadie creo compras! </h2>";
}
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
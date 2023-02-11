<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
    $objProducto = new c_producto();
    $arrayProductos = $objProducto->buscar(null);
    if ($arrayProductos != null) {
        $cantProductos = count($arrayProductos);
    } else {
        $cantProductos = -1;
    }
    $i = 0;
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head> -->
<!-- <body> -->
<div class="container col-md-10">
    <!-- <form action="" class="form-control needs-validation" method="POST" novalidate>         
    <table id="formulario_CrearProducto" class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Url Imagen</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" name="proNombre" id="" class="form-control" required>
                    <div class="valid-feedback mb-1">bien</div>
                    <div class="invalid-feedback mb-1">ingrese un nombre valido</div>
                </td>
                <td>
                    <input type="text" name="proDetalle" id="" minlength="10" class="form-control" required>
                    <div class="valid-feedback mb-1">biem</div>
                    <div class="invalid-feedback mb-1">ingrese una descripcion 10 letras min</div>
                </td>
                <td>
                    <input type="number" name="proCantStock" id="" min="1" class="form-control" required>
                    <div class="valid-feedback mb-1">bien</div>
                    <div class="invalid-feedback mb-1">stock minimo "1"</div>
                </td> 


                <td>
                    <input type="number" name="proPrecio" id="" min="1" class="form-control" required>
                    <div class="valid-feedback mb-1">bien</div>
                    <div class="invalid-feedback mb-1">precio minimo "1"</div>
                </td>
                <td>
                    <input type="url" name="urlImagen" id="" class="form-control" required>
                    <div class="valid-feedback mb-1">bien</div>
                    <div class="invalid-feedback mb-1">ingrese un url</div>
                </td>
                <td>
                    <input class="btn btn-success me-2" type="submit" name="boton_enviar" value="Agregar" class="form-control">
                </td>
            </tr>
        </tbody>
    </table>
    </form> -->
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
                                    <!-- <th class="invisible-cell">URL</th> -->
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
                                if(isset($arrayProductos)){ //isset se fija si la variable tiene algo
                                    foreach ($arrayProductos as $producto){ 
                                        echo '<tr>';
                                        echo '<td><img src="'.$producto->getUrlItem().'" alt="" height="100" width="100"></td>';
                                        echo '<td style= display:none;>' .$producto->getUrlItem().'</td>';
                                        echo '<td>' .$producto->getIdProducto().'</td>';
                                        echo '<td>'. $producto->getProNombre().'</td>';
                                        echo '<td>'. $producto->getProDetalle().'</td>';
                                        echo '<td>'. $producto->getProPrecio().'</td>';
                                        echo '<td>'. $producto->getProCantStock().'</td>';
                                        echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Producto</button>';
                                       /*  echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                                        echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>'; */
                                        echo '</tr>';
                                    }
                                }else{
                                    echo '<p class="lead"> Actualmente no hay productos registrados </p>';
                                }
                            ?>
                </div>
            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role= "document">
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
    include_once("../menu/pie.php");
?>
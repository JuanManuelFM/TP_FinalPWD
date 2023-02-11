<?php
include_once("../Menu/Cabecera.php");
include_once("../../configuracion.php");


/* ESTO DEL SESSION LO HACE MANU */
$idUsuario= 1;// esto es provisional
$controlCompraItem= new c_compraItem();
?>
<html>
<head>

</head>
<body>

<div class="container align-items-center " style="margin-top: 50px;">
<div class="col-12" style="text-align: end;">
  <button id="myInput">
    <img src="css/img/carrito.png" alt="carrito" width="60px" style="text-align: end;">
  </button>
</div>


<table class="table table-hover table-bordered">
  <thead class="">
    <thead class="table-dark">
      <th colspan="3" scope="col" id="nombreCliente">usuario</td>
      <th colspan="3" scope="col" >botones</td>  
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="carrito">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>
<?php
include_once("../menu/pie.php");
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../bootstrap/js/bootstrap.min.js"></script>    
</html>
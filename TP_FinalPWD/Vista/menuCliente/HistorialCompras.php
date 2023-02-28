<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");

$idUsuarioAux= 1;

/* aca van las mejores funciones creadas por el hombre */

function buscarCompraItemsDeunaCompra($idCompra){
  $idCompra= intval($idCompra);
  $objc_compraItem= new c_compraItem();

  $arrayCompasItems= $objc_compraItem->buscar(["idcompra"=> $idCompra]);

  return $arrayCompasItems;
}


function arrayComprasDeUnUsuario($idUsuario){
  $objC_Compra= new c_compra();
  $idUsuario= intval($idUsuario);
  //error
  $arrayComprasDeUnUsuario= $objC_Compra->buscar(["idUsuario" => $idUsuario]);


  return $arrayComprasDeUnUsuario;
}

function buscarCompraEstadosDeUnaCompra($idCompra){
  $idCompra= intval($idCompra);
  $objC_compraEstado= new c_compraEstado();
  $arrayComprasEstado= $objC_compraEstado->buscar(["idCompra" => $idCompra]);


  return $arrayComprasEstado;
}

function crearhistorialCompras($idUsuario){
  $idUsuario= intval($idUsuario);


  $comprasUsuario= arrayComprasDeUnUsuario($idUsuario);

  $i= 1;
  foreach ($comprasUsuario as $compra) {//recorro
    
    crearCabecera($compra, $i);
    
    $arrayComprtaItems= buscarCompraItemsDeunaCompra(intval($compra->getIdCompra()));

    foreach ($arrayComprtaItems as $compraItem) {
      crearCuerpo($compraItem);
    }


    crearModal($compra, $i);

    
    $i++;



    echo "
    </tbody>
  </table>
  </div>
  ";

  }

  /* ahora busco los obj compra item para el cuerpo */

}

function crearCabecera($objCompra, $numero){


  

  echo "
  
<div class=\"container align-items-center \" style=\"margin-top: 50px;\">

<table class=\"table table-hover table-bordered\">
  <thead class=\"\">
    <thead class=\"table-dark\">
      <th colspan=\"4\" scope=\"col\">idCompra:{$objCompra->getIdCompra()}</td>
      <th colspan=\"3\" scope=\"col\"><button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#historial{$numero}\">HISTORIAL</button></td>
    </thead>
  </thead>
  
  ";
}

function crearCuerpo($objCompraItem){
  $idProducto= $objCompraItem->getObjProducto()->getIdProducto();
  $getProNombre= $objCompraItem->getObjProducto()->getProNombre();
  $urlItem= $objCompraItem->getObjProducto()->getUrlItem();
  $detalle= $objCompraItem->getObjProducto()->getProDetalle();
  $cantida= $objCompraItem->getCiCantidad();
  $precio= $objCompraItem->getObjProducto()->getProPrecio();
  $a= 1;
echo "
<tr>
  <td>{$objCompraItem->getObjProducto()->getIdProducto()}</td>
  <td>{$objCompraItem->getObjProducto()->getProNombre()}</td>
  <td>{$objCompraItem->getObjProducto()->getUrlItem()}</td>
  <td>{$objCompraItem->getObjProducto()->getProDetalle()}</td>
  <td>{$objCompraItem->getCiCantidad()}</td>
  <td>$ {$precio}</td>
</tr>";
}

function crearModal($objCompra, $numero){

  $idCompra= $objCompra->getIdCompra();

  $c_compra= new c_compraEstado();
  $arrayCompraEstados= $c_compra->buscar(["idCompra"=>$idCompra]);
  $numero= intval($numero);

  $string= "";

  $string=  "
<table class=\"table table-hover table-bordered\">
  <thead>
    <th>estado</th>
    <th>fechaIni</th>
    <th>fechaFinal</th>
  </thead>
  <tbody>
  
  ";




foreach ($arrayCompraEstados as $compraEstados) {
  //$compraEstados= new CompraEstado();


  //$compraEstadoTipo= new CompraEstadoTipo;
  //$compraEstados->getCeFechaFIN()
  $string .= "
  
    <tr>
      <td>{$compraEstados->getObjCompraEstadoTipo()->getCetDescripcion()}</td>
      <td>{$compraEstados->getCeFechaINI()}</td>
      <td>{$compraEstados->getCeFechaFIN()}</td>      
    </tr>
  ";
}

  


$string.="
</tbody>
</table>
</div>";

  echo $string;


}






?>


<html>
<head>

</head>

<body>
    

<?php
crearhistorialCompras($idUsuarioAux);
?>
<!-- 
<div class="modal fade" id="historial1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      

<div class="container align-items-center " >
<table class="table table-hover table-bordered">
  <thead>
    <th>estado</th>
    <th>fechaIni</th>
    <th>fechaFinal</th>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td></td>
      <td></td>      
    </tr>
  </tbody>
</table>
</div>





      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->










</body>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</html>
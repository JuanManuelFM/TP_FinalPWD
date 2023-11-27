<?php

include_once("../../../configuracion.php");

$datos = data_submitted();
//
$obj_producto = new C_Producto();
$sesion = new c_session();
$obj_compra = new c_compra();
$objCompraEstado = new c_compraEstado();
//

$usuarioController = new c_usuario();
$compraEstadoController = new c_compraEstado();
$compraEstadoTipoController = new c_compraEstadoTipo();
$compraController = new c_compra();
$compraItemController = new c_compraItem();
$productoController = new c_producto();
$listadoDeCompras = $compraController->buscar(['idUsuario' => $datos['idUsuario']]);

$ultimaCompra = null;

//Busco el producto que se está agregando al carrito
$productoComprado = $productoController->buscar(['idProducto' => $datos['idProducto']])[0];

//Verifico que la cantidad agregada al carrito no sea mayor a la del stock disponible
if ($productoComprado->getProCantStock() < $datos['ciCantidad']) {
    echo json_encode(['success' => 0, 'message' => 'No hay suficiente stock del producto seleccionado']);
    exit;
}

$datosModificacionProducto = [
    'idProducto' => $datos['idProducto'],
    'proCantStock' => $productoComprado->getProCantStock() - $datos['ciCantidad'],
    'proNombre' => $productoComprado->getProNombre(),
    'proDetalle' => $productoComprado->getProDetalle(),
    'proPrecio' => $productoComprado->getProPrecio(),
    'urlItem' => $productoComprado->getUrlItem()
];

//Modifico el stock del producto
$productoController->modificacion($datosModificacionProducto);

if ($listadoDeCompras && count($listadoDeCompras) > 0) {
    //La ultima posicion del listado es la última compra realizada
    $ultimaCompra = $listadoDeCompras[count($listadoDeCompras) - 1];
    //Verifico que la última compra esté iniciada y no en otro estado
    $listadoComprasEstado = $compraEstadoController->buscar(['idCompra' => $ultimaCompra->getIdCompra()]);
    if ($listadoComprasEstado && $listadoComprasEstado[0] && $listadoComprasEstado[0]->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() != 1) {
        //Si la última compra ya pasó a otro estado difrente de iniciada, entonces se vuelve nula
        $ultimaCompra = null;
    }
}

//Si no hay una compra iniciada, inicia una nueva
if (!$ultimaCompra) {
    if ($ultimaCompra = $compraController->alta(['idCompra' => 'DEFAULT', 'idUsuario' => $usuarioController->buscar(['idUsuario' => $datos['idUsuario']])[0], 'coFecha' => "DEFAULT"])) {
        $listadoDeCompras = $compraController->buscar(['idUsuario' => $datos['idUsuario']]);
        $ultimaCompra = $listadoDeCompras[count($listadoDeCompras) - 1];
        if (!$compraEstadoController->alta([
            'idCompra' => $ultimaCompra,
            'idCompraEstadoTipo' => $compraEstadoTipoController->buscar(['idCompraEstadoTipo' => 1])[0],
            'ceFechaIni' => "DEFAULT",
            'ceFechaFin' => "DEFAULT"
        ])) {
            echo json_encode(['success' => 0, 'message' => 'Error en la creación de compra estado']);
            exit;
        }
        $compraEstadoUltimaCompra = $compraEstadoController->buscar(['idCompra' => $ultimaCompra->getIdCompra()])[0];
    } else {
        $productoController->modificacion([...$datosModificacionProducto, 'proCantStock' => $productoComprado->getProCantStock()]);
        echo json_encode(["success" => 0, "message" => "Error en la creación de la compra"]);
        exit;
    }
}

$productosCompra = $compraItemController->buscar(['idCompra' => $ultimaCompra->getIdCompra(), 'idProducto' => $productoComprado->getIdProducto()]);

if ($productosCompra && count($productosCompra) > 0) {
    $objCompraItem = $productosCompra[0];
    $compraItemController->modificacion(['idCompraItem' => $objCompraItem->getIdCompraItem(), 'idCompra' => $ultimaCompra, 'idProducto' => $productoComprado, 'ciCantidad' => $objCompraItem->getCiCantidad() + $datos['ciCantidad']]);
} else {
    if (!$compraItemController->alta(['idCompra' => $ultimaCompra, 'ciCantidad' => $datos['ciCantidad'], 'idProducto' => $productoComprado])) {
        $productoController->modificacion([...$datosModificacionProducto, 'proCantStock' => $productoComprado->getProCantStock()]);
        echo json_encode(['success' => 0, 'message' => 'Error al sumar el producto a la compra']);
        exit;
    }
}
echo json_encode(['success' => 1, 'message' => 'Producto agregado correctamente al carrito']);


exit;


/* buscar ultima compra de un usuario */
// $array_compraEstadoIniciada = $objCompraEstado->buscarCompraEstadoNull($idUsuario);

// if (count($array_compraEstadoIniciada) <> 0) {
//     /* en caso e tener una compra iniciada significa que la compra se tiene que agregar a esa compra */
//     $objCompraEstado = $array_compraEstadoIniciada[0];
//     $idCompraActual = $objCompraEstado->getObjCompra()->getIdCompra();
//     $objCompraItem = new c_compraItem();
//     /* lo necesario para el alta */
//     $objProductoAux = new Producto();
//     $objProductoAux->buscar(intval($datos["idProducto"]));
//     if ($obj_producto->hayStock($datos["idProducto"], $datos["ciCantidad"])) { //valido si hay stock de ese producto
//         $objCompraItem->alta([
//             'idcompraitem' => null,
//             "idproducto" => $objProductoAux,
//             "idcompra" => $objCompraEstado->getObjCompra(),
//             "cicantidad" => intval($datos["ciCantidad"])
//         ]);
//         $obj_producto->restarStock(intval($datos['idProducto']), $datos["ciCantidad"]);
//         echo json_encode(array('success' => 1));
//     } else {
//         echo json_encode(array('success' => 0));
//     }
// } else { //en caso de no encontrar ninguna compra estado iniciada creariamos una nueva compra
//     $obj_compra = new c_compra();
//     $obj_compra->crearNuevaCompra($idUsuario);
//     /* ahora una forma de buscar la ultima compra */
//     //SELECT * FROM `compra` WHERE `idCompra` = (SELECT MAX(idCompra) FROM compra)
//     $ultimaCompraCreada = $obj_compra->buscarUltimaCompraCreada();
//     $idCompraCreada = $ultimaCompraCreada->getIdCompra(); //obtengoo el id de la ultima compra creada
//     /* ahora creada la compra le asigno el producto comprado */
//     $objCompraItemAux = new c_compraItem();
//     $objCompraItemAux->crearCompraItem($datos['idProducto'], $datos['ciCantidad'], $idCompraCreada);
//     /* me recontra olvide de agregar el nuevo compraEstado jajjasjasjasjajjassjaajsja*/
//     $objCompraEstado = new CompraEstado();
//     $objCompraEstado->insertar_Id_Ce($idCompraCreada, 1);
//     echo json_encode(array('success' => 1));
// }

/*
$producto = $obj_producto->buscar(array( 'idproducto' => $datos['id_producto']));

if ($producto != null) {//en caso de no existir el producto
    $producto= new Producto;
    if(intval($producto[0]->getProCantStock()) >= intval($dato['ciCantidad'])){
        $obj_compra= new c_compra();
        $compra_iniciada= $obj_compra->buscarComprasEstadosIniciado($sesion->getIdUsuario());

        if (is_array($compra_iniciada) && $compra_iniciada != null) {
            $obj_compra_item= new c_compraItem();

            $productoitem=  $obj_compra_item->buscar(['idProducto'=> $datos['idProducto'],'idCompra'=> $compra_iniciada[0]->getIdCompra()]);

            if(is_array($productoitem) && $productoitem != null){
                $productoitem= $productoitem[0];
                $productoitem->setCiCantidad(intval($productoitem->getCiCantidad()) + intval($datos['ciCantidad']));
                $productoitem= new CompraItem();
                $param= [
                    'idCompraItem'=> $productoitem->getIdCompraItem(),
                    'idProducto'=> $compra_iniciada[0]->getIdCompra(),
                    'ciCantidad'=>$productoitem->getCiCantidad()
                ];
                $obj_compra_item->modificacion($param);
            } else {
                $obj_compra_item->alta(['idCompraItem'=>NULL, 'idProducto'=>$datos['idProducto'],
                'idCompra'=>$compra_iniciada[0]->getIdCompra
                ])
            }
        }
    }
}

if($producto != null){
    //aca se valida el stock de productos, no se donde mas se debe validar
    //no es mio
    if($producto[0]->getProcantstock() >= $datos['cantidad'] || $producto[0]->getProcantstock() <= $datos['cantidad']){
        $obj_compra = new C_Compra();
        $compra_borrador = $obj_compra->obtener_compra_borrador_de_usuario($sesion->getIdUser());

        if(is_array($compra_borrador) && $compra_borrador != null){
            $obj_compra_item = new C_Compraitem();

            $productoitem = $obj_compra_item->buscar(['idproducto' => $datos['id_producto'],'idcompra' => $compra_borrador[0]->getIdcompra()]);

            if(is_array($productoitem) && $productoitem != null){
                $productoitem = $productoitem[0];
                $productoitem->setCicantidad($productoitem->getCicantidad()+$datos['cantidad']);
                $param = array(
                    'idcompraitem' => $productoitem->getIdcompraitem(),
                    'idproducto' =>  $datos['id_producto'],
                    'idcompra' => $compra_borrador[0]->getIdcompra(),
                    'cicantidad' =>$productoitem->getCicantidad()
                );
                $obj_compra_item->modificacion($param);
            }else{
                $obj_compra_item->alta(['idcompraitem'=>NULL, 'idproducto'=>$datos['id_producto'], 'idcompra'=>$compra_borrador[0]->getIdcompra(), 'cicantidad'=>$datos['cantidad']]);
            }

        }else{
            $compra_borrado = new C_Compra();
            $compra_estado = new C_Compraestado();
            $objCompraItem = new C_Compraitem();
            $param_compra = array(
                'idcompra'  => NULL,
                'cofecha'  => date('Y-m-d H:i:s'),
                'idusuario'  => $sesion->getIdUser(),
            );
            $compra_borrado->alta($param_compra);
            $compra = $compra_borrado->buscar(['cofecha'=> $param_compra['cofecha'], 'idusuario'=>$param_compra['idusuario']]);
            $compra_estado->alta(['idcompraestado'=>NULL, 'idcompra'=>$compra[0]->getIdcompra(), 'idcompraestadotipo'=>0, 'cefechaini'=>$param_compra['cofecha'], 'cefechafin'=>NULL]);
            $objCompraItem->alta(['idcompraitem'=>NULL, 'idproducto'=>$datos['id_producto'], 'idcompra'=>$compra[0]->getIdcompra(), 'cicantidad'=>$datos['cantidad']]);
        }
    }
}

/*
function buscarComprasUsuario($idUsuario)
{
    $objCompra = new C_Compra();
    $arrayCompra = $objCompra->buscar($idUsuario);
    return $arrayCompra;
}

function cargarProducto($objCompraEstadoBorrador, $datos)
{
    $objCompraItem = new C_CompraItem();
    $arrayCompraItem = $objCompraItem->buscar($datos);
    $datos["idCompra"] = $objCompraEstadoBorrador->getCompra()->getIdCompra();
    $objCompraItemRepetido = productoRepetido($arrayCompraItem, $datos["idCompra"]);
    if ($objCompraItemRepetido == null) {
        if ($objCompraItem->alta($datos)) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0));
        }
    } else {
        $cantStockDisp = $objCompraItemRepetido->getObjProducto()->getCantStock();
        $cantTot = $datos["ciCantidad"] + $objCompraItemRepetido->getCantidad();
        if ($cantTot > $cantStockDisp) {
            echo json_encode(array('success' => 0));
        } else {
            $param = [
                "idCompraItem" => $objCompraItemRepetido->getIdCompraItem(),
                "idProducto" => $objCompraItemRepetido->getObjProducto()->getIdProducto(),
                "idCompra" => $objCompraItemRepetido->getObjCompra()->getIdCompra(),
                "ciCantidad" => $cantTot
            ];
            $objCompraItem->modificacion($param);
            echo json_encode(array('success' => 1));
        }
    }
}

function productoRepetido($arrayCompraItem, $idCompra)
{
    $resp = null;
    if ($arrayCompraItem != null) {
        foreach ($arrayCompraItem as $compraItem) {
            if ($compraItem->getObjCompra()->getIdCompra() == $idCompra) {
                $resp = $compraItem;
            }
        }
    }
    return $resp;
}

function crearCompra($idUsuario)
{
    $objCompra = new C_Compra();
    $objCompraEstado = new C_CompraEstado();
    $arrayObjCompraEstado = null;
    if ($objCompra->alta($idUsuario)) {
        $arrayCompra = $objCompra->buscar($idUsuario);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $paramCompraEstado = [
            "idCompra" => end($arrayCompra)->getIdCompra(),
            "idCompraEstadoTipo" => 1,
            "ceFechaIni" => $fechaStamp,
            "ceFechaFin" => null
        ];
        if ($objCompraEstado->alta($paramCompraEstado)) {
            $idCompra["idCompra"] = end($arrayCompra)->getIdCompra();
            $arrayObjCompraEstado = $objCompraEstado->buscar($idCompra);
        }
    }
    return $arrayObjCompraEstado[0];
}

*/
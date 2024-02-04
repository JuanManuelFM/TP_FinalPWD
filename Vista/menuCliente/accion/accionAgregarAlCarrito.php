<?php

include_once("../../../configuracion.php");

$datos = data_submitted();
//
/* $obj_producto = new c_producto();
$sesion = new c_session();
$obj_compra = new c_compra();
$objCompraEstado = new c_compraEstado(); */
//

//Que no recarge al no elegir nada para comprar
if ($datos['ciCantidad'] <= 0) {
    echo json_encode(['success' => 0, 'message' => "La cantidad del producto es inválida"]);
    exit;
}

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
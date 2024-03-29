<?php

class c_compraitem
{
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compraitem
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idCompraItem', $param)) {
            $obj = new CompraItem();
            $obj->cargar(
                $param['idCompraItem'],
                $param['idProducto'],
                $param['idCompra'],
                $param['ciCantidad']
            );
        }
        return $obj;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idCompraItem'])) {
            $obj = new CompraItem();
            $obj->cargar($param['idCompraItem'], null, null, null);
        }
        return $obj;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idCompraItem']))
            $resp = true;
        return $resp;
    }

    /** Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idCompraItem'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /** permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /** permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null && $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /** permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            $where .= '';
            if (isset($param['idCompraItem']))
                $where .= " and idCompraItem ='" . $param['idCompraItem'] . "'";
            if (isset($param['idProducto']))
                $where .= " and idProducto ='" . $param['idProducto'] . "'";
            if (isset($param['idCompra']))
                $where .= " and idCompra ='" . $param['idCompra'] . "'";
            if (isset($param['ciCantidad']))
                $where .= " and ciCantidad ='" . $param['ciCantidad'] . "'";
        }
        $obj = new CompraItem();
        $arreglo =  $obj->listar($where);
        return $arreglo;
    }

    //Devuelve el carrito iniciado de un usuario
    public function carritoIniciado($id)
    {
        /* inicializo variables */
        $compraIniciada = [];
        $objCompraEstado = new CompraEstado();
        $objCompra = new Compra();
        $objCompra->getIdCompra();
        $compraEstados1 = $objCompraEstado->listar("idCompraEstadoTipo = 1"); //Todos las compras estados iniciadas 1
        if ($compraEstados1 != null) {
            foreach ($compraEstados1 as $compraE) {
                $compra = $compraE->getObjCompra();
                if ($compra->getObjUsuario()->getIdUsuario() == $id) {
                    array_push($compraIniciada, $compraE);
                }
            }
        }
        return $compraIniciada;
    }

    // Crea carrito segun ID usuario
    public function crearCarrito($id)
    {
        $carrito = $this->carritoIniciado($id);
        $i = 0;
        if (count($carrito) > 0) {
            foreach ($carrito as $item) {
                $idCompra = $item->getObjCompra()->getIdCompra();
                $compraItem = new CompraItem();
                $arrayCompraItems = $compraItem->listar("idCompra = {$idCompra}");
                if ($arrayCompraItems && ($arrayCompraItems) > 0) {
                    foreach ($arrayCompraItems as $items) {
                        $this->formatoCarrito($items);
                    }
                }
                $i++;
            }
        } else {
            echo "
            <tr>
                <th scope=\"row\" colspan=\"6\">no hay nada en el carrito</th>
            </tr>";
        }
    }

    /** Crea el carrito con compraitem
     * @param obj $objCompraItem
     */
    public function formatoCarrito($objCompraItem)
    {
        $objProducto = $objCompraItem->getObjProducto();
        echo "
      <tr id=\"row{$objCompraItem->getIdCompraItem()}\">
        <th scope=\"row\">{$objProducto->getIdProducto()}</th>
        <td>{$objProducto->getProNombre()}</td>
        <td style=\"text-align:center;\">
            <img width='65px' src=\"{$objProducto->getUrlItem()}\" alt='eliminar' class='img_producto'>        
        </td>
        <td>{$objProducto->getProDetalle()}</td>
        <td>{$objCompraItem->getCiCantidad()}</td>
        <td>
            <form class=\"form needs-validation Eliminar\" novalidate>
                <input type=\"number\" name=\"idCompraItem\" value=\"{$objCompraItem->getIdCompraItem()}\" class=\"d-none\">
                <input type=\"submit\"  alt='eliminar' class=\"eliminarCss\" value=\"X\" >
            </form>
        </td>
      </tr>";
    }

    public function crearCompraItem($idProducto, $cantidad, $idCompra)
    {
        $objCompraitem = new CompraItem();
        $objCompraAux = new c_compra();
        $objProducto = new c_producto();
        //posible error
        $objProductoAux = $objProducto->buscar(["idProducto" => $idProducto]);
        $compraEncontrada = $objCompraAux->buscar(["idCompra" => intval($idCompra)]);
        $objCompraitem->cargar(null, $objProductoAux[0], $compraEncontrada[0], intval($cantidad));
        $objCompraitem->insertar();
    }
}

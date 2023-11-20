<?php

class c_compraItem
{
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compraitem
     */
    private function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idcompraitem', $param)) {
            $obj = new Compraitem();
            $obj->cargar(
                $param['idcompraitem'],
                $param['idproducto'],
                $param['idcompra'],
                $param['cicantidad']
            );
        }
        return $obj;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        if (isset($param['idcompraitem'])) {
            $obj = new Compraitem();
            $obj->cargar($param['idcompraitem'], null, null, null);
        }
        return $obj;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idcompraitem']))
            $resp = true;
        return $resp;
    }

    /** Inserta un objeto
     * @param array $param
     */
    public function alta($param){
        $resp = false;
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
    public function baja($param){
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
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $obj= $this->cargarObjeto($param);
            if($obj!=null && $obj->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /** permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true "; 
        if ($param<>NULL){
            $where .= '';
            if  (isset($param['idcompraitem']))
                $where.=" and idcompraitem ='".$param['idcompraitem']."'"; 
            if  (isset($param['idproducto']))
                    $where.=" and idproducto ='".$param['idproducto']."'";
            if  (isset($param['idcompra']))
                    $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['cicantidad']))
                    $where.=" and cicantidad ='".$param['cicantidad']."'";
        }
        $obj = new Compraitem();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }

    //Devuelve el carrito iniciado de un usuario
    public function carritoIniciado($id){
    /* inicializo variables */
    $compraIniciada= [];
    $objCompraEstado= new CompraEstado();
    $objCompra= new Compra();
    $objCompra->getIdCompra();
    $compraEstados1= $objCompraEstado->listar("idCompraEstadoTipo = 1"); //Todos las compras estados iniciadas 1
    if ($compraEstados1 != null) {
        foreach ($compraEstados1 as $compraE) {
            $compra= $compraE->getObjCompra();
            if ($compraE->getObjCompra()->getObjUsuario()->getIdUsuario() == $id) {
               array_push($compraIniciada, $compraE);
            }
        }
    }
    return $compraIniciada;
    }
    
    // Crea carrito segun ID usuario
    public function crearCarrito($id){
        $carrito= $this->carritoIniciado($id);
        $i= 0;
        foreach ($carrito as $item) {
            $idCompra= $item->getObjCompra()->getIdCompra();
            $compraItem= new CompraItem();
            $arrayCompraItems= $compraItem->listar("idCompra = {$idCompra}");
        foreach ($arrayCompraItems as $items) {
          $this->formatoCarrito($items);
        }
        $i++;
      }
      if ($i == 0) {
      /* echo "
      <tr>
        <th scope=\"row\" colspan=\"6\">no hay nada en el carrito</th>
      </tr>"; */
      }
    }
    
    /** Crea el carrito con compraitem
     * @param obj $objCompraItem
     */
    public function formatoCarrito($objCompraItem){
      $objProducto= $objCompraItem->getObjProducto();
      echo "
      <tr>
        <th scope=\"row\">{$objProducto->getIdProducto()}</th>
        <td>{$objProducto->getProNombre()}</td>
        <td style=\"text-align:center;\">
            <img width='65px' src=\"{$objProducto->getUrlItem()}\" alt='eliminar' class='img_producto'>        
        </td>
        <td>{$objProducto->getProDetalle()}</td>
        <td>{$objCompraItem->getCiCantidad()}</td>
        <td>
            <form action=\"accion/eliminarDeCarrito.php\" method=\"post\" class=\"form needs-validation eliminar\" novalidate>
                <input type=\"number\" name=\"idCompraItem\" value=\"{$objProducto->getIdProducto()}\" class=\"d-none\">
                <input  onclick=\"enviarFormulario();\" type=\"submit\"  alt='eliminar' class=\"eliminarCss\" value=\"X\" >
            </form>
            <button onclick=\"alert('eliminar');background-color= 'none'; \" style=\"border: none; background-color: transparent;\" alt='eliminar'><img width='24px' src=\"css/img/Skull-icon.png\" alt='eliminar'></button>
            <button onclick=\"alert('eliminar');background-color= 'none'; \" style=\"border: none; background-color: transparent;\" alt='editar'><img width='24px' src=\"css/img/editar.png\" alt='editar'></button>
        </td>
      </tr>";
    }

    public function crearCompraItem($idProducto, $cantidad, $idCompra){
        $objCompraitem= new CompraItem();
        $objCompraAux= new c_compra();
        $objProducto= new c_producto();
        //posible error
        $objProductoAux= $objProducto->buscar(["idProducto"=>$idProducto]);
        $compraEncontrada= $objCompraAux->buscar(["idCompra"=> intval($idCompra)]);
        $objCompraitem->cargar(null, $objProductoAux[0], $compraEncontrada[0], intval($cantidad));
        $objCompraitem->insertar();
    }
}
?>



<?php

class c_compraEstadoTipo
{
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compraestadotipo
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idCompraEstadoTipo', $param)) {
            $obj = new CompraEstadoTipo();
            $obj->cargar(
                $param['idCompraEstadoTipo'],
                $param['cetDescripcion'],
                $param['cetDetalle'],
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
        if (isset($param['idCompraEstadoTipo'])) {
            $obj = new CompraEstadoTipo();
            $obj->cargar($param['idCompraEstadoTipo'], null, null);
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
        if (isset($param['idCompraEstadoTipo']))
            $resp = true;
        return $resp;
    }

    /** Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idCompraEstadoTipo'] = null;
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

    public function aceptarCompra($param){
        $resp = false;
        $fecha = new DateTime();
        //Modifico estado anterior de la compra
        $compraEstadoOld = new compraEstado();
        $compraEstadoOld->buscarUltimoEstado($param);
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $compraEstadoOld->setCeFechaFIN($fechaStamp);
        //error con fecha en modificar??? Revisar modificar de compra estado. Fijarme si el compra estado "buscarUltimoEstado" devuelve algo
        $compraEstadoOld->modificar();
        $compraEstadoActual = new compraEstado();
        $objCompra = new compra();
        $objCompra->buscar($param);
        $objCompraEstadoTipo = new compraEstadoTipo();
        $objCompraEstadoTipo->buscar(2);
        $compraEstadoActual->cargar(null, $objCompra, $objCompraEstadoTipo, $fechaStamp , null);
        $compraEstadoActual->insertar();
        return $resp = true;
        }

    /** permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true "; 
        if ($param<>NULL){
            $where .= '';
            if  (isset($param['idCompraEstadoTipo']))
                $where.=" and idCompraEstadoTipo ='".$param['idCompraEstadoTipo']."'"; 
            if  (isset($param['cetDescripcion']))
                $where.=" and cetDescripcion ='".$param['cetDescripcion']."'";
            if  (isset($param['cetDetalle']))
                $where.=" and cetDetalle ='".$param['cetDetalle']."'";
        }
        $obj = new CompraEstadoTipo();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }
}
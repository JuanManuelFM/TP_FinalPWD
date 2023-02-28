<?php
class c_compraEstado{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compraestado
     */
    private function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idCompraEstado', $param)){
            $obj = new CompraEstado();
            $obj->cargar(
                $param['idCompraEstado'],
                $param['idCompra'],
                $param['idCompraEstadotipo'],
                $param['ceFechaINI'],
                $param['cefechaFIN']
            );
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idCompraEstado'])) {
            $obj = new CompraEstado();
            $obj->cargar($param['idCompraEstado'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idCompraEstado']))
            $resp = true;
        return $resp;
    }

    /**
     * Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idCompraEstado'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
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

    /**
     * permite modificar un objeto
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

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true "; 
        if ($param<>NULL){
            $where .= '';
            if  (isset($param['idCompraEstado']))
                $where.=" and idCompraEstado ='".$param['idCompraEstado']."'"; 
            if  (isset($param['idCompra']))
                    $where.=" and idCompra ='".$param['idCompra']."'";
            if  (isset($param['idCompraEstadoTipo']))
                    $where.=" and idCompraEstadoTipo ='".$param['idCompraEstadoTipo']."'";
            if  (isset($param['ceFechaIni']))
                    $where.=" and ceFechaIni ='".$param['ceFechaIni']."'";
            if  (isset($param['ceFechaFin']))
                    $where.=" and ceFechaFin ='".$param['ceFechaFin']."'";
        }
        $obj = new Compraestado();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }

    /**
     * permite buscar el objeto compra estado con fecha fin en null, este null significa que la compra sigue activa
     * devuelve el array vacio en caso de no tener ninguna compraEstado en estado 1 (iniciada) 
     * @param array $param
     * @return array
     */
    public function buscarCompraEstadoNull($id){
        $where = " true "; 
            $where .= '';
            $where.=" and ceFechaFin is null";
            $where.= " and idCompraEstadoTipo= 1";
        
        $obj = new Compraestado();
        $arreglo =  $obj->listar($where);//analizar esto
        
        /* ahora que tengo el arreglo con las compra estados iniciadas filtro las que tengan el id compra que quiero*/
        $arregloFiltrado= [];
        
        if ($arreglo != null) {
            foreach ($arreglo as $compraEstado) {
            
                $objCompraAux= $compraEstado->getObjCompra();
    
                if (intval($objCompraAux->getObjUsuario()->getIdUsuario()) == intval($id)) {
                    array_push($arregloFiltrado, $compraEstado);
                }
            }
        }
        return $arregloFiltrado;
    }

    public function buscarCompraIniciada($arrayCompra){
        $objCompraEstadoInciada = null;
        $i = 0;
        /* Busca en el array de compra si hay alguna que este con el estado "iniciada" (tipo 1) */
        while (($objCompraEstadoInciada == null) && ($i < count($arrayCompra))) {
            $idCompra["idCompra"] = $arrayCompra[$i]->getIdCompra();
            $arrayCompraEstado = $this->buscar($idCompra);
            if ($arrayCompraEstado[0]->getCompraEstadoTipo()->getCetDescripcion() == "iniciada") {
                $objCompraEstadoInciada = $arrayCompraEstado[0];
            } else {
                $i++;
            }
        }
        return $objCompraEstadoInciada;
    }

    //HACE LO MISMO QUE LA DE ARRIBA
    //HACE LO MISMO QUE LA DE ARRIBA
    //HACE LO MISMO QUE LA DE ARRIBA
    //HACE LO MISMO QUE LA DE ARRIBA

    /* public function buscarCompras($arrayCompra){
        $arrayCompraIniciadas = [];
        // Busca en el array de compra si hay alguna que este con el estado "iniciada" (tipo 1)
        foreach ($arrayCompra as $compra) {
            $idCompra["idCompra"] = $compra->getIdCompra();
            $arrayCompraEstado = $this->buscar($idCompra);
            if (count($arrayCompraEstado) > 1) {
                foreach ($arrayCompraEstado as $compraEstado) {
                    if ($compraEstado->getCeFechaFin() == "0000-00-00 00:00:00") {
                        array_push($arrayCompraIniciadas, $compraEstado);
                    }
                }
            } else {
                if ($arrayCompraEstado[0]->getCompraEstadoTipo()->getIdCompraEstadoTipo() >= 2) {
                    array_push($arrayCompraIniciadas, $arrayCompraEstado[0]);
                }
            }
        }
        return $arrayCompraIniciadas;
    } */
}   
<?php

class c_menu
{
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idMenu', $param)) {
            $obj = new Menu();
            $obj->cargar(
                $param['idMenu'],
                $param['meNombre'],
                $param['meDescripcion'],
                null,
                $param['meDeshabilitado'],
                );
        }
        return $obj;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idMenu'])) {
            $obj = new Menu();
            $obj->cargar($param['idMenu'], null, null, null, null);
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
        if (isset($param['idMenu']))
            $resp = true;
        return $resp;
    }

    /** Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idMenu'] = null;
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

    /** permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = "true"; 
        if ($param<>NULL){
            $where .= '';
            if  (isset($param['idMenu']))
                $where.=" and idMenu ='".$param['idMenu']."'"; 
            if  (isset($param['meNombre']))
                    $where.=" and meNombre ='".$param['meNombre']."'";
            if  (isset($param['meDescripcion']))
                    $where.=" and meDescripcion ='".$param['meDescripcion']."'";
            if  (isset($param['idPadre']))
                    $where.=" and idPadre ='".$param['idPadre']."'";
            if  (isset($param['meDeshabilitado']))
                    $where.=" and meDeshabilitado ='".$param['meDeshabilitado']."'";
        }
        $obj = new Menu();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }

    public function listar($arrayBusqueda)
    {
        $objMenu = new Menu();
        $resp = $objMenu->listar($arrayBusqueda);
        if ($resp != null) {
            $arrayMenues = $resp;
        } else {
            $arrayMenues = null;
        }
        return $arrayMenues;
    }

    // Deshabilita un menu 
    public function deshabilitar($param){
        $resp = false;
        $arrayMenues = $this->buscar($param);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $objMenu = $arrayMenues[0];
        $objMenu->setMeDeshabilitado($fechaStamp);
        if ($objMenu != null and $objMenu->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    // Habilita un menu 
    public function habilitar($param){
        $resp = false;
        $arrayObjMenues = $this->buscar($param);
        $objMenu = $arrayObjMenues[0];
        $objMenu->setMeDeshabilitado('habilitar');
        if ($objMenu!= null and $objMenu->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function noBaja($param)
    {
        $resp = false;
        //ARREGLAR PARA QUE EL DESHABILITADO CAMBIE
        // $obj = new Menu();
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->noEliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }
}
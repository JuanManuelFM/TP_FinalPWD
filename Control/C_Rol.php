<?php
class c_rol{

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objRoleto
     * @param array $param
     * @return objRolect
     */
    private function cargarObjRol($param){
        $objRol = null;
        if (array_key_exists('idRol', $param)){
            $objRol = new rol();
            if(!$objRol->cargar(
                $param['idRol'], 
                $param['rolDescripcion'])){
            }
        }
        return $objRol;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objRoleto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjRolConClave($param){
        $objRol = null;
        if (isset($param['idRol'])) {
            $objRol = new rol();
            $objRol->cargar($param['idRol'], null);
        }
        return $objRol;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idRol']))
            $resp = true;
        return $resp;
    }

    /**
     * Inserta un objRoleto
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idRol'] =null;
        $objRol = $this->cargarObjRol($param);
        if ($objRol != null and $objRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objRoleto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objRol = $this->cargarObjRolConClave($param);
            if ($objRol != null and $objRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite modificar un objRoleto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objRol= $this->cargarObjRol($param);
            if($objRol!=null && $objRol->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objRoleto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true "; 
        if ($param<>null){
            $where .= '';
            if  (isset($param['idRol']))
                $where.=" and idRol ='".$param['idRol']."'"; 
            if  (isset($param['rolDescripcion']))
                    $where.=" and rolDescripcion ='".$param['rolDescripcion']."'";
        }
        $objRol = new Rol();
        $arreglo =  $objRol->listar($where);  
        
        return $arreglo;
    }

    public function obtenerObj($arrayId){
        $objRoles=[];
        foreach($arrayId as $idRol){
            $param['idRol']=$idRol;
            $objRol=$this->buscar($param);
            array_push($objRoles, $objRol[0]);
        }
        return $objRoles;
    }
}
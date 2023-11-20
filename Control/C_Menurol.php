<?php

class c_menuRol{
    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menurol
     */
    private function cargarObjeto($param)
    {
        $objMenuRol = null;
        $objMenu = null;
        $objRol = null;
        if (array_key_exists('idMenu', $param) and array_key_exists('idRol', $param)) {
            $objMenu = new Menu();
            $objMenu->setIdMenu($param['idMenu']);
            $objRol = new Rol();
            $objRol->setIdRol($param['idRol']);
            $objMenuRol = new MenuRol();
            $objMenuRol->cargar($objMenu, $objRol);
        }
        return $objMenuRol;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idMenu'])) {
            $obj = new MenuRol();
            $obj->cargar($param['idMenu'], null);
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
        if (isset($param['idMenu'], $param['idRol']))
            $resp = true;
        return $resp;
    }

    /** Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);
        if ($objMenuRol != null and $objMenuRol->insertar()) {
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
            $objMenuRol = $this->cargarObjetoConClave($param);
            if ($objMenuRol != null and $objMenuRol->eliminar()) {
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
    public function buscar($param)
    {
        $where = "true"; 
        if ($param<>NULL){
            if  (isset($param['idMenu']))
                $where.=" and idMenu ='".$param['idMenu']."'";
            if  (isset($param['idRol']))
                $where.=" and idRol ='".$param['idRol']."'";
        }
        $objMenuRol = new MenuRol();
        $arreglo =  $objMenuRol->listar($where);  
        return $arreglo;
    }

    /* public function menusByIdRol($idRoles){
        $arrayMenuRol= [];
        foreach ($idRoles as $idRol){
            $idRolActual= $idRol->getObjRol()->getIdRol();
            $param= ['idRol' => $idRolActual];
            $arrayDeMenuRol[]= $this->buscar($param);
        }
        $menuRoles= [];
        foreach($arrayDeMenuRol as $menuRol){
            if(is_array($menuRol)){
                //Si es un array, recorre sus posiciones y las agrega
                foreach($menuRol as $posicion){
                    $menuRoles[] = $posicion;
                }
            } else {
                //Si no es array, simplemente lo agrega.
                $menuRoles[] = $menuRol;
            }
        }
        foreach($menuRoles as $menuRol){
            $arrayDeMenues[] = $menuRol->getIdMenu();
        }
        $arrayDeMenues = array_unique($arrayDeMenues); //Elimina elementos repetidos del array
        return $arrayDeMenues;
    } */

    // Elige menus para mostrar segun el rol
    public function menuesByIdRol($objRol){
        $param['idRol'] = $objRol;
        $objMenuObjRol = $this->buscar($param);
        $menuesRoles = [];
        foreach ($objMenuObjRol as $objMenuRol) {
            if (is_array($objMenuRol)) {
                foreach ($objMenuRol as $objMR) {
                    array_push($menuesRoles, $objMR);
                }
            } else {
                array_push($menuesRoles, $objMenuRol);
            }
        }
        $menues = [];
        foreach ($menuesRoles as $objetos) {
            array_push($menues, $objetos->getObjMenu());
        }
        return $menues;
    }
}
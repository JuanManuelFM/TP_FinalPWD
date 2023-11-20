<?php

class c_usuarioRol
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $objUsuarioRol = null;
        $objRol = null;
        $objUsuario = null;
        if (array_key_exists('idRol', $param) && array_key_exists('idUsuario', $param)) {
            $objRol = new Rol();
            $objRol->setIdRol($param['idRol']);
            $objUsuario = new Usuario();
            $objUsuario->setIdUsuario($param['idUsuario']);
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->cargar($objUsuario, $objRol);
        }
        return $objUsuarioRol;
    }

    /** Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objUsuarioRol = null;
        //print_R ($param);
        if (isset($param['idUsuario']) && isset($param['idRol'])) {
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->cargar($param['idUsuario'], $param['idRol']);
        }
        return $objUsuarioRol;
    }

    /** Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idUsuario']) && isset($param['idRol']));
        $resp = true;
        return $resp;
    }

     /** 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        if ($objUsuarioRol != null) {
            if ($objUsuarioRol->insertar()) {
                $resp = true;
            }
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
            $objUsuarioRol = $this->cargarObjetoConClave($param);
            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()) {
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
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null and $objUsuarioRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /** permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> null) {
            $where .= '';
            if (isset($param['idUsuario']))
                $where .= " and idUsuario='" . $param['idUsuario'] . "'";
            if (isset($param['idRol']))
                $where .= " and idRol ='" . $param['idRol'] . "'";
        }
        $objUsuarioRol = new UsuarioRol();
        $arrayUsuarioRol = $objUsuarioRol->listar($where);
        return $arrayUsuarioRol;
    }

    //esta funcion me devuelve un array de descripcion de roles de un array de usuarios:
    public function darDescripcionRoles($arrayUsuarios)
    {
        $rolesUs = [];
        foreach ($arrayUsuarios as $us) {
            $param['idUsuario'] = $us->getIdUsuario();
            array_push($rolesUs, $this->buscar($param));
        }
        $rolesDesc = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getRolDescripcion();
                array_push($roles, $rol);
            }
            array_push($rolesDesc, $roles);
        }
        return $rolesDesc;
    }

    public function darIdRoles($arrayUsuarios)
    {
        $rolesUs = [];
        foreach ($arrayUsuarios as $us) {
            $param['idUsuario'] = $us->getIdUsuario();
            array_push($rolesUs, $this->buscar($param));
        }
        $rolesId = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getIdRol();
                array_push($roles, $rol);
            }
            array_push($rolesId, $roles);
        }
        return $rolesId;
    }
}
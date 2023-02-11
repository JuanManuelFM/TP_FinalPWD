<?php
class c_usuario
{

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (array_key_exists('idUsuario', $param)) {
            $obj = new Usuario();
            $obj->cargar(
                $param['idUsuario'],
                $param['usNombre'],
                $param['usPass'],
                $param['usMail'],
                $param['usDeshabilitado']
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
        if (isset($param['idUsuario'])) {
            $obj = new Usuario();
            $obj->cargar($param['idUsuario'], null, null, null, null);
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
        if (isset($param['idUsuario']))
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
        $usuarioNombre['usNombre'] = $param['usNombre'];
        if ($this->buscar($usuarioNombre) == null){
            $param['idUsuario'] = null;
            $param['usDeshabilitado'] = null;
            $obj = $this->cargarObjeto($param);
            if ($obj != null and $obj->insertar()) {
                $this->altaRol($obj);
                $resp = true;
            }
        }
        return $resp;
    }

    public function altaRol($objUsuario){
        $idUsuario = $objUsuario->getIdUsuario();
        $usRol = new c_usuarioRol();
        //por defecto al crearse el usuario se le asigna el rol de USER (id:2)
        $datosUsuarioRol['idRol'] = 2;
        $datosUsuarioRol['idUsuario'] = $idUsuario;
        $resp = $usRol->alta($datosUsuarioRol);
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

    public function noBaja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->noEliminar()) {
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
            if  (isset($param['idUsuario']))
                $where.=" and idUsuario ='".$param['idUsuario']."'"; 
            if  (isset($param['usNombre']))
                    $where.=" and usNombre ='".$param['usNombre']."'";
            if  (isset($param['usPass']))
                    $where.=" and usPass ='".$param['usPass']."'";
            if  (isset($param['usMail']))
                    $where.=" and usMail ='".$param['usMail']."'";
            if  (isset($param['usDeshabilitado']))
                    $where.=" and usDeshabilitado ='".$param['usDeshabilitado']."'";
        }
        $obj = new Usuario();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }

    // Busca un usuario
    public function buscarViejo($param){
        $where = " true "; 
        if ($param<>NULL){
            $where .= '';
            if  (isset($param['idUsuario']))
                $where.=" and idUsuario ='".$param['idUsuario']."'"; 
            if  (isset($param['usNombre']))
                    $where.=" and usNombre ='".$param['usNombre']."'";
            if  (isset($param['usPass']))
                    $where.=" and usPass ='".$param['usPass']."'";
            if  (isset($param['usMail']))
                    $where.=" and usMail ='".$param['usMail']."'";
            if  (isset($param['usDeshabilitado']))
                    $where.=" and usDeshabilitado ='".$param['usDeshabilitado']."'";
        }
        $obj = new Usuario();
        $arreglo =  $obj->listarViejo($where);  
        
        return $arreglo;
    }

    //Preguntar (no debería haber una fecha?)
    /* public function habilitar($param){
        $resp = false;
        $arrayObjUsuarios = $this->buscar($param);
        $objUsuario = $arrayObjUsuarios[0];
        $objUsuario->setUsDeshabilitado('habilitar');
        if ($objUsuario != null and $objUsuario->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function deshabilitar($param){
        $resp = false;
        $arrayObjUsuarios = $this->buscar($param);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $objUsuario = $arrayObjUsuarios[0];
        $objUsuario->setUsDeshabilitado($fechaStamp);
        if ($objUsuario != null and $objUsuario->modificar()){
            $resp = true;
        }
        return $resp;
    } */

    public function listar ($arrayBusqueda){
        $objUsuario = new Usuario();
        $resp = $objUsuario->listar($arrayBusqueda);
        if(array_key_exists('array', $resp)){
            $arrayUsuarios = $resp['array'];
        }else{
            $arrayUsuarios = [];
        }
        return $arrayUsuarios;
    }
}
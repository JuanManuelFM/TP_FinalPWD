<?php
class c_session
{

    public function getIdUsuario()
    {
        if (isset($_SESSION['idUsuario'])) {
            return $_SESSION['idUsuario'];
        }
        return null;
    }

    public function setIdUsuario($idUsuario)
    {
        $_SESSION['idUsuario'] = $idUsuario;
    }

    public function getUsNombre()
    {
        if (array_key_exists('nombreUsuario', $_SESSION)) {
            $param = $_SESSION['nombreUsuario'];
        } else {
            $param = null;
        }
        return $param;
    }

    public function setUsNombre($usNombre)
    {
        $_SESSION['nombreUsuario'] = $usNombre;
    }

    public function getUsPass()
    {
        return $_SESSION['usPass'];
    }

    public function setUsPass($usPass)
    {
        $_SESSION['usPass'] = $usPass;
    }

    public function getUsDeshabilitado()
    {
        return $_SESSION['usDeshabilitado'];
    }

    public function setUsDeshabilitado($usDeshabilitado)
    {
        $_SESSION['usDeshabilitado'] = $usDeshabilitado;
    }

    /** CONSTRUCTOR **/
    public function __construct()
    {
        if (session_status() == 1) {
            session_start();
        }
    }

    /** INICIAR **/
    /* public function iniciar($nombreUsuario, $passUsuario){
        $this->setUsNombre($nombreUsuario);
        $this->setUsPass($passUsuario);
    } */
    /* public function iniciar($nombreUsuario, $passUsuario) {
        $resp = false;
        $obj = new c_usuario();
        $param['usNombre'] = $nombreUsuario;
        $param['usPass'] = $passUsuario;
        $param['usDeshabilitado'] = 'null';

        $resultado = $obj->buscar($param);

        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $_SESSION['idUsuario'] = $usuario->getIdUsuario();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    } */

    /* public function iniciar($nombreUsuario, $arrayRoles){
        $_SESSION["nombreUsuario"] = $nombreUsuario;
        $_SESSION["roles"] = $arrayRoles;
        $objRol = new C_Rol();
        $param = [2];
        $_SESSION["vista"] = $objRol->obtenerObj($param)[0];
    } */

    public function iniciar($nombreUsuario, $roles)
    {
        $_SESSION['idUsuario'] = $nombreUsuario->getIdUsuario();
        $_SESSION["nombreUsuario"] = $nombreUsuario->getUsNombre();
        $_SESSION["roles"] = $roles;
        $this->setVista($roles[0]);
    }

    public function setVista($objRol)
    {
        $_SESSION["vista"] = $objRol;
    }

    public function getVista()
    {
        return $_SESSION["vista"];
    }

    public function validar($param)
    {
        $objUsuario = new c_usuario();
        $arrayUsuario = $objUsuario->buscar($param);
        $resp = false;
        if ($arrayUsuario != null) {
            if ($param["usPass"] == $arrayUsuario[0]->getUsPass()) {
                $idRoles = $this->getRol($arrayUsuario[0]);
                $this->iniciar($arrayUsuario[0], $idRoles);
                $resp = true;
            }
        }
        return $resp;
    }

    public function objUsuarioRegistrado()
    {
        $resp = null;
        if (isset($_SESSION['nombreUsuario'])) {
            $objUsuario = new c_usuario();
            $param['usNombre'] = $_SESSION['nombreUsuario'];
            $resp = $objUsuario->buscar($param);
        }
        return $resp;
    }

    /** ACTIVA **/
    public function activa()
    {
        $resp = false;
        if (isset($_SESSION['nombreUsuario'])) {
            $resp = true;
        }
        return $resp;
    }

    /** GET USUARIO **/
    public function getUsuario()
    {
        $controlUsuario = new c_usuario();
        if (array_key_exists('idUsuario', $_SESSION)) {
            $where = ['idUsuario' => $_SESSION['idUsuario']];
        } else {
            $where = [];
        }
        $listaUsuarios = $controlUsuario->buscar($where);
        if ($listaUsuarios >= 1) {
            $usuarioLog = $listaUsuarios[0];
        }
        return $usuarioLog;
    }

    public function getRol($objUsuarioRegistrado)
    {
        $objUsuarioRol = new C_UsuarioRol();
        $param["idUsuario"] = $objUsuarioRegistrado->getIdUsuario();
        $arrayObjRolesUsuario = $objUsuarioRol->buscar($param);
        $arrayRol = [];
        foreach ($arrayObjRolesUsuario as $rol) {
            array_push($arrayRol, $rol->getObjRol());
        }
        $idRoles = [];
        foreach ($arrayRol as $objRol) {
            array_push($idRoles, $objRol->getIdRol());
        }
        return $idRoles;
    }

    /* public function getRoles(){
        $usuarioActual = $this->getUsuario();
        $objUsuarioRol = new c_usuarioRol();
        $param = ['idUsuario' => $usuarioActual->getIdUsuario()];
        $listaRoles = $objUsuarioRol->buscar($param);
        return $listaRoles;
    } */

    public function tienePermisos()
    {
        $tienePermisos = false;
        $objUsuarioRol = new c_usuarioRol();
        if ($this->activa()) {
            $where = ['idUsuario' => $this->getIdUsuario(), 'idRol' => $this->getRolActual()];
            $resp = $objUsuarioRol->buscar($where);
            if ($resp != null && $this->getUsDeshabilitado() != null) {
                $tienePermisos = true;
            }
        }
        return $tienePermisos;
    }

    function permisosMenu($data)
    {
        $resp = false;
        if (isset($data['idMenu'])) {
            $objMenuRol = new c_menuRol();
            $where = ['idMenu' => $data['idMenu'], 'idRol' => $_SESSION['idRol']];
            $param = $objMenuRol->buscar($where);
            if (count($param) != 0) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * Devuelve el rol del usuario logeado.
     */
    /* public function getRolLogin() {
        $list_rol = null;
        if ($this->validar()) {
            $obj = new c_usuarioRol();
            $param['idUsuario'] = $_SESSION['idUsuario'];
            $param['idRol'] = $_SESSION['idRol'];

            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $list_rol = $resultado;
            }
        }
        return $list_rol;
    }

    public function getColRol() {
        $list = null;
        if ($this->validar()) {
            $obj = new c_usuarioRol();
            $param['idUsuario'] = $_SESSION['idUsuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $list = $resultado;
            }
        }
        $res = $this->filtrarRoles($list);
        return $res;
    }
    private function filtrarRoles($list) {
        foreach ($list as $rol) {
            $res[] = $rol->getObjRol();
        }
        return $res;
    } */

    // public function getVista(){
    //     $resp= null;
    //     if($_SESSION['vista']!= null){
    //         $resp= $_SESSION['vista'];
    //     }
    //     return $resp;
    // }

    /** CERRAR **/
    public function cerrar()
    {
        session_unset();
        session_destroy();
    }
}

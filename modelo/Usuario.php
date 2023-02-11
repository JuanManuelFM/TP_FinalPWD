<?php
//TERMINADO (ver situación de modificar)
class Usuario extends baseDatos{
    use Condicion;
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail; 
    private $usDeshabilitado;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idUsuario = "";
        $this->usNombre = "";
        $this->usPass = "";
        $this->usMail = '';
        $this->usDeshabilitado = "";
    }

    public function cargar($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado){
        $this->setIdUsuario($idUsuario);
        $this->setUsNombre($usNombre);
        $this->setUsPass($usPass);
        $this->setUsMail($usMail);
        $this->setUsDeshabilitado($usDeshabilitado);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function getUsNombre(){
        return $this->usNombre;
    }

    public function setUsNombre($usNombre){
        $this->usNombre = $usNombre;
    }

    public function getUsPass(){
        return $this->usPass;
    }

    public function setUsPass($usPass){
        $this->usPass = $usPass;
    }

    public function getUsMail(){
        return $this->usMail;
    }

    public function setUsMail($usMail){
        $this->usMail = $usMail;
    }

    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }

    public function setUsDeshabilitado($usDeshabilitado){
        $this->usDeshabilitado = $usDeshabilitado;
    }

    public function getMensajeFuncion(){
        return $this->mensajeFuncion;
    }

    public function setMensajeFuncion($mensajeFuncion){
        $this->mensajeFuncion = $mensajeFuncion;
    }

    //Funciones BD

    //INSERTAR
    public function insertar(){
        $resp = false;
        $base = new baseDatos();
        $sql = "INSERT INTO usuario (usNombre, usPass, usMail, usDeshabilitado) 
                VALUES(
                '" .$this->getUsNombre(). "',
                '" .$this->getUsPass(). "',
                '" .$this->getUsMail(). "',
                default);";
        if ($base->Iniciar()) {
            if ($idIncersion = $base->Ejecutar($sql)) {
                $this->setIdUsuario($idIncersion);
                $resp = true;
            } else {
                $this->setMensajeFuncion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeFuncion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    //MODIFICAR
    public function modificar(){
        $base = new baseDatos();
        $resp = false;
        //Hago consulta sql
        if($this->getUsDeshabilitado() == null){
            $param = "Default";
        }else{
            $param = $this->getUsDeshabilitado();
        }
        $consulta = "UPDATE usuario SET usNombre= '".$this->getUsNombre()."', usPass= '".$this->getUsPass()."', usMail= '".$this->getUsMail()."', usDeshabilitado = ". $param ." WHERE idUsuario= ". $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    //BUSCAR
    public function buscar($idUsuario)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM usuario WHERE idUsuario = " .$idUsuario;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($usuario = $base->Registro()) {
                    $this->setIdUsuario($idUsuario);
                    $this->setUsNombre($usuario['usNombre']);
                    $this->setUsPass($usuario['usPass']);
                    $this->setUsMail($usuario['usMail']);
                    $this->setUsDeshabilitado($usuario['usDeshabilitado']);
                    $resp = true;
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    //LISTAR
     public function listarViejo($condicion = ''){
        $arregloUsuarios = null;
        $base = new baseDatos();
        $consultaUsuario =  "SELECT * from usuario";
        if ($condicion != '') {
            $consultaUsuario = $consultaUsuario . ' WHERE ' . $condicion;
        }
        $consultaUsuario .= " ORDER BY idUsuario ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaUsuario)) {
                $arregloUsuarios = array();
                while ($usuario = $base->Registro()) {
                    $objUsuario = new Usuario();
                    $objUsuario->buscar($usuario['idUsuario']);
                    array_push($arregloUsuarios, $objUsuario);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloUsuarios;
    }

    public function listar($arrayBusqueda){
        //seteo de respuesta
        $respuesta['respuesta'] = false;
        $respuesta['errorInfo'] = '';
        $respuesta['codigoError'] = null;
        $arregloUsuario = null;
        $base = new baseDatos();
        //seteo de busqueda
        $stringBusqueda = $this->SB($arrayBusqueda);
        $sql = "SELECT * FROM usuario";
        if($stringBusqueda != ''){
            $sql.= ' WHERE ';
            $sql.= $stringBusqueda;
        }
        try {
            if($base->Iniciar()){
                if($base->Ejecutar($sql)){
                    $arregloUsuario = array();
                    while($row2 = $base->Registro()){
                        $objUsuario = new Usuario();
                        $objUsuario->setIdusuario($row2['idUsuario']);
                        $objUsuario->setUsnombre($row2['usNombre']);
                        $objUsuario->setUspass($row2['usPass']);
                        $objUsuario->setUsmail($row2['usMail']);
                        $objUsuario->setUsdeshabilitado($row2['usDeshabilitado']);
                        array_push($arregloUsuario, $objUsuario);
                    }
                    $respuesta['respuesta'] = true;
                }else{
                   /*  Usuario::setMensajeStatic($base->getError()); */
                    $respuesta['respuesta'] = false;
                    $respuesta['errorInfo'] = 'Hubo un error con la consulta';
                    $respuesta['codigoError'] = 1;
                }
            }else{
                /* Usuario::setMensajeStatic($base->getError()); */
                $respuesta['respuesta'] = false;
                $respuesta['errorInfo'] = 'Hubo un error con la conexión de la base de datos';
                $respuesta['codigoError'] = 0;
            }
        } catch (\Throwable $th) {
            $respuesta['respuesta'] = false;
            $respuesta['errorInfo'] = $th;
            $respuesta['codigoError'] = 3;
        }
        $base = null;
        if($respuesta['respuesta']){
            $respuesta['array'] = $arregloUsuario;
        }
        return $respuesta;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            // $consulta = "DELETE FROM usuario WHERE idUsuario = " . $this->getIdUsuario();
            $consulta = "UPDATE usuario SET usDeshabilitado = CURRENT_TIMESTAMP WHERE idUsuario =" .$this->getIdUsuario();
            if ($base->Ejecutar($consulta)){
                $resp = true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function noEliminar(){
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            // $consulta = "DELETE FROM usuario WHERE idUsuario = " . $this->getIdUsuario();
            $consulta = "UPDATE usuario SET usDeshabilitado = DEFAULT WHERE idUsuario =" .$this->getIdUsuario();
            if ($base->Ejecutar($consulta)){
                $resp = true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function __toString()
    {
        return (
            "ID del usuario: " . $this->getIdUsuario() ."\n Nombre del usuario: " . $this->getUsNombre() .
            "\n Contraseña del usuario: " . $this->getUsPass() .
            "\n Email del usuario: " . $this->getUsMail() . 
            "\n Usuario deshabilitado: " . $this->getUsDeshabilitado() . "\n");
    }
    
}
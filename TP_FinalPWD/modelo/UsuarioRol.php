<?php
//REVISAR LISTAR
class UsuarioRol extends baseDatos
{
    private $objUsuario;
    private $objRol;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->objUsuario = new Usuario();
        // $this->objUsuario = ''; Es una alternativa
        $this->objRol = new Rol();
    }

    public function cargar($objUsuario, $objRol)
    {
        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol); 
    }

    //Metodos de acceso
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }

    public function getObjRol()
    {
        return $this->objRol;
    }

    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;
    }

    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    //Funciones BD

    //INSERTAR
    public function insertar()
    {
        $base = new baseDatos();
        $resp = false;
        
        //Creo la consulta 
        $consulta = "INSERT INTO usuariorol (idUsuario, idRol) VALUES ('".
        $this->getObjUsuario()->getIdUsuario()."',
        '".$this->getObjRol()->getIdRol(). "')"; 
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

    //MODIFICAR
    public function modificar()
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "UPDATE usuariorol SET 
        idUsuario = '".$this->getObjUsuario()->getIdUsuario()."', 
        idRol = ".$this->getObjRol()->getIdRol()." 
        WHERE idUsuario = '".$this->getObjUsuario()->getIdUsuario()."' AND idRol = '".$this->getObjRol()->getIdRol()."'";
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
    public function buscar($idUsuario, $idRol){
        $base = new baseDatos();
        $resp = false;
        //PROBLEMA, NO ESTÁ BIEN ESCRITO
        $consulta = "SELECT * FROM usuariorol WHERE idUsuario ='".$idUsuario."' AND idRol = '". $idRol."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($usuarioRol = $base->Registro()) {
                    //Creo un objeto para buscar al id y setear el objeto
                    $objUsuario = new Usuario();
                    $objUsuario->buscar($usuarioRol['idUsuario']);
                    $this->setObjUsuario($objUsuario);
                    $objRol = new Rol();
                    $objRol->buscar($usuarioRol['idRol']);
                    $this->setObjRol($objRol);
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

    //LISTAR (REVISAR)
    public function listar($condicion = ''){
        $arregloUsuarioRol = null;
        $base = new baseDatos();
        $consultaUserRol =  "SELECT * from usuariorol ";
        if ($condicion != '') {
            $consultaUserRol = $consultaUserRol . ' WHERE ' . $condicion;
        }
        $consultaUserRol .= " ORDER BY idUsuario ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaUserRol)) {
                $arregloUsuarioRol = array();
                while ($usuarioRol = $base->Registro()) {
                    $objUsuarioRol = new UsuarioRol();
                    $objUsuarioRol->buscar($usuarioRol['idUsuario'], $usuarioRol['idRol']);
                    array_push($arregloUsuarioRol, $objUsuarioRol);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloUsuarioRol;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM usuariorol WHERE idUsuario= '". $this->getObjUsuario()->getIdUsuario()."' 
            AND idRol= '" . $this->getObjRol()->getIdRol() ."'";
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

    public function __toString()
    {
        return (
            "ID del usuario: " . $this->getObjUsuario()->getIdUsuario() .
            "\n ID rol: " . $this->getObjRol()->getIdRol() . "\n");
    }
}

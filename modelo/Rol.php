<?php
//TERMINADO (ver situación de modificar)
class Rol extends baseDatos
{
    private $idRol;
    private $rolDescripcion;
    private $mensajeFuncion;
    

    public function __construct()
    {
        $this->idRol = "";
        $this->rolDescripcion = "";
       
    }

    public function cargar($idRol, $rolDescripcion)
    {
        $this->setIdRol($idRol);
        $this->setRolDescripcion($rolDescripcion);
    }

    //Metodos de acceso
    public function getIdRol(){
        return $this->idRol;
    }

    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }

    public function getRolDescripcion(){
        return $this->rolDescripcion;
    }

    public function setRolDescripcion($rolDescripcion){
        $this->rolDescripcion = $rolDescripcion;
    }

    public function getMensajeFuncion(){
        return $this->mensajeFuncion;
    }

    public function setMensajeFuncion($mensajeFuncion){
        $this->mensajeFuncion = $mensajeFuncion;
    }

    //Funciones BD

    //INSERTAR
    public function insertar()
    {
        $base = new baseDatos();
        $resp = false;
        //Creo la consulta 
        $consulta = "INSERT INTO rol (idRol, rolDescripcion) VALUES (
            '" . $this->getIdRol() . "',
            '" . $this->getRolDescripcion() . "')";
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
        $consulta = "UPDATE rol SET
        rolDescripcion = '".$this->getRolDescripcion()."' 
        WHERE idRol = ".$this->getIdRol();
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
    public function buscar($idRol){
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM rol WHERE idRol =" . $idRol;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($rol = $base->Registro()) {
                    $this->setIdRol($idRol);
                    $this->setRolDescripcion($rol['rolDescripcion']);
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
    public function listar($condicion = "")
    {
        $arregloRoles = null;
        $base = new baseDatos();
        $consultaRol =  "SELECT * from rol ";
        if ($condicion != '') {
            $consultaRol = $consultaRol . ' WHERE ' . $condicion;
        }
        $consultaRol .= " ORDER BY idRol ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaRol)) {
                $arregloRoles = array();
                while ($rol = $base->Registro()) {
                    $objRol = new Rol();
                    $objRol->buscar($rol['idRol']);
                    array_push($arregloRoles, $objRol);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloRoles;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM rol WHERE idRol =" . $this->getIdRol();
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

    public function __toString(){
        return(
            "ID del rol: " . $this->getIdRol() . "\n 
            Detalles del rol: " . $this->getRolDescripcion() . "\n");
    }
}
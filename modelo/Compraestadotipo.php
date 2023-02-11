<?php
//REVISAR MODIFICAR
class CompraEstadoTipo extends baseDatos
{
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idCompraEstadoTipo = "";
        $this->cetDescripcion = "";
        $this->cetDetalle = "";
    }

    public function cargar($idCompraEstadoTipo, $cetDescripcion, $cetDetalle)
    {
        $this->setIdCompraEstadoTipo($idCompraEstadoTipo);
        $this->setCetDescripcion($cetDescripcion);
        $this->setCetDetalle($cetDetalle);
    }

    //Metodos de acceso
    
    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }

    public function setIdCompraEstadoTipo($idCompraEstadoTipo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }

    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }

    public function setCetDescripcion($cetDescripcion){
        $this->cetDescripcion = $cetDescripcion;
    }

    public function getCetDetalle(){
        return $this->cetDetalle;
    }

    public function setCetDetalle($cetDetalle){
        $this->cetDetalle = $cetDetalle;
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
        $consulta = "INSERT INTO compraestadotipo (idCompraEstadoTipo, cetDescripcion, cetDetalle) VALUES ('".
        $this->getIdCompraEstadoTipo()."',
        '".$this->getCetDescripcion()."',
        '".$this->getCetDetalle()."')"; 
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
        $consulta = "UPDATE Compraestadotipo SET
        cetDescripcion = '".$this->getCetDescripcion()."', 
        cetDetalle = '".$this->getCetDetalle()."' 
        WHERE idCompraEstadoTipo = ". $this->getIdCompraEstadoTipo();
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
    public function buscar($idCompraEstadoTipo)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM compraestadotipo WHERE idCompraEstadoTipo =" . $idCompraEstadoTipo;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($CET = $base->Registro()) {
                    $this->setIdCompraEstadoTipo($idCompraEstadoTipo);
                    $this->setCetDescripcion($CET['cetDescripcion']);
                    $this->setCetDetalle($CET['cetDetalle']);
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
    public function listar($condicion = ''){
        $arrayCET = null;
        $base = new baseDatos();
        $consultaCET = "SELECT * from compraestadotipo";
        if ($condicion != '') {
            $consultaCET = $consultaCET . ' WHERE ' . $condicion;
        }
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCET)) {
                $arrayCET = array();
                while ($CET = $base->Registro()) {
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->buscar($CET['idCompraEstadoTipo']);
                    array_push($arrayCET, $objCompraEstadoTipo);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arrayCET;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compraestadotipo WHERE idCompraEstadoTipo = " . $this->getIdCompraEstadoTipo();
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
            "ID de CET: " . $this->getIdCompraEstadoTipo() .
            "\n Descripción CET: " . $this->getCetDescripcion() .
            "\n Detalles CET: " . $this->getCetDetalle() . "\n");
    }
    
}

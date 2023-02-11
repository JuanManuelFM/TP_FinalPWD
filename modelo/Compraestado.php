<?php
class CompraEstado extends baseDatos{
    private $idCompraEstado;
    private $objCompra;
    private $objCompraEstadoTipo;
    private $ceFechaINI; 
    private $ceFechaFIN;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idCompraEstado = "";
        $this->objCompra = new Compra();
        $this->objCompraEstadoTipo = new CompraEstadoTipo();
        $this->ceFechaINI = '';
        $this->ceFechaFIN = "";
    }

    public function cargar($idCompraEstado, $objCompra, $objCompraEstadoTipo, $ceFechaINI, $ceFechaFIN)
    {
        $this->setIdCompraEstado($idCompraEstado);
        $this->setObjCompra($objCompra);
        $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
        $this->setCeFechaINI($ceFechaINI);
        $this->setCeFechaFIN($ceFechaFIN);
    }

    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }

    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }

    public function getObjCompra(){
        return $this->objCompra;
    }

    public function setObjCompra($objCompra){
        $this->objCompra = $objCompra;
    }

    public function getObjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }

    public function setObjCompraEstadoTipo($objCompraEstadoTipo){
        $this->objCompraEstadoTipo = $objCompraEstadoTipo;
    }

    public function getCeFechaINI(){
        return $this->ceFechaINI;
    }

    public function setCeFechaINI($ceFechaINI){
        $this->ceFechaINI = $ceFechaINI;
    }

    public function getCeFechaFIN(){
        return $this->ceFechaFIN;
    }

    public function setCeFechaFIN($ceFechaFIN){
        $this->ceFechaFIN = $ceFechaFIN;
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
        $base = new baseDatos();
        $resp = false;
        
        //Creo la consulta 
        $consulta = "INSERT INTO compraestado (idCompraEstado, idCompra, idCompraEstadoTipo, ceFechaINI, ceFechaFIN) VALUES (
        DEFAULT,
        '".$this->getObjCompra()->getIdCompra()."',
        '".$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()."',
        '".$this->getCeFechaINI()."',
        '".$this->getCeFechaFIN()."')";
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

    /* INSERTA UN COMPRA ESTADO TIPO INICIAL SOLO CON EL ID COMPRA  y el compra estado tipo que queramos*/
    public function insertar_Id_Ce($idCompra, $compraEstadoTipo){
        $base = new baseDatos();
        $resp = false;

        $compraEstadoTipo= intval($compraEstadoTipo);
        $idCompra= intval($idCompra);
        
        //Creo la consulta 
        $consulta = "INSERT INTO compraestado (idCompraEstado, idCompra, idCompraEstadoTipo, ceFechaINI, ceFechaFIN) VALUES (
        DEFAULT,
        {$idCompra},
        {$compraEstadoTipo},
        DEFAULT,
        NULL)";
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
        
        $consulta = "UPDATE compraestado
        SET 
        idCompra = '".$this->getObjCompra()->getIdCompra()."',
        idCompraEstadoTipo = '".$this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo()."',
        ceFechaINI = '".$this->getCeFechaINI()."',
        ceFechaFIN = ".$this->getCeFechaFIN()."
        WHERE idCompraEstado = ".$this->getIdCompraEstado();
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
    public function buscar($idCompraEstado)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM compraestado WHERE idCompraEstado = " . $idCompraEstado;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($compraEstado = $base->Registro()) {
                    $this->setIdCompraEstado($idCompraEstado);
                    //Creo un objeto para buscar al id y setear el objeto
                    $objCompra = new Compra();
                    $objCompra->buscar($compraEstado['idCompra']);
                    $this->setObjCompra($objCompra);
                    $objCompraEstadoTipo = new CompraEstadoTipo();
                    $objCompraEstadoTipo->buscar($compraEstado['idCompraEstadoTipo']);
                    $this->setObjCompraEstadoTipo($objCompraEstadoTipo);
                    $this->setCeFechaINI($compraEstado['ceFechaIni']);
                    $this->setCeFechaFIN($compraEstado['ceFechaFin']);
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
    public function listar($condicion = '')
    {
        $arrayCET = null;
        $base = new baseDatos();
        $consultaCET =  "SELECT * from compraestado";
        if ($condicion != '') {
            $consultaCET = $consultaCET . ' WHERE ' . $condicion;
        }
                    $consultaCET.=" ORDER BY idCompraEstado ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCET)) {
                $arrayCET = array();
                while ($compraEstado = $base->Registro()) {
                    $objCompraEstado = new CompraEstado();
                    $objCompraEstado->buscar($compraEstado['idCompraEstado']);
                    array_push($arrayCET, $objCompraEstado);
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
    public function eliminar(){
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compraestado WHERE idCompraEstado = " . $this->getIdCompraEstado();
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
        return ( 
            "ID compra estado: " . $this->getIdCompraEstado() .
            "\n ID de compra: " . $this->getObjCompra()->getIdCompra() .
            "\n ID CET: " . $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() .
            "\n Fecha inicio compra: " . $this->getCeFechaINI() .
            "\n Fecha inicio compra: " . $this->getCeFechaFIN() . "\n");
    }
    
}
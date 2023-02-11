<?php
//REVISAR COSAS
class Compra extends baseDatos{
    private $idCompra;
    private $coFecha;
    private $objUsuario; //Delegación 
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idCompra = "";
        $this->coFecha = "";
        $this->objUsuario = new Usuario();
    }

    public function cargar($idCompra, $coFecha, $objUsuario)
    {
        $this->setIdCompra($idCompra);
        $this->setCoFecha($coFecha);
        $this->setObjUsuario($objUsuario);
    }

    //Metodos de acceso
    
    public function getIdCompra(){
        return $this->idCompra;
    }

    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }

    public function getCoFecha(){
        return $this->coFecha;
    }

    public function setCoFecha($coFecha){
        $this->coFecha = $coFecha;
    }

    public function getObjUsuario(){
        return $this->objUsuario;
    }

    public function setObjUsuario($objUsuario){
        $this->objUsuario = $objUsuario;
    }

    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    //INSERTAR
    public function insertar()
    {
        $base = new baseDatos();
        $resp = false;

        $objque= $this->getObjUsuario();
        
        //Creo la consulta 
        $consulta = "INSERT INTO compra (idCompra, coFecha, idUsuario) VALUES ('".
        $this->getIdCompra()."',
        '".$this->getCoFecha()."',
        '".$this->getObjUsuario()->getIdUsuario()."')";
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

    public function nuevaCompra()
    {
        $base = new baseDatos();
        $resp = false;

        $objque= $this->getObjUsuario();
        
        //Creo la consulta 
        $consulta = "INSERT INTO compra (idCompra, coFecha, idUsuario) VALUES (DEFAULT,DEFAULT,{$this->getObjUsuario()->getIdUsuario()})";
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
        //coFecha SE MODIFICA??????????? Está DEFAULT
        $consulta = "UPDATE compra SET 
        coFecha= '".$this->getCoFecha()."',
        idUsuario = ".$this->getObjUsuario()->getIdUsuario()."
        WHERE idCompra= ". $this->getIdCompra();
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
    public function buscar($idCompra)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM compra WHERE idCompra = " . $idCompra;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($compra = $base->Registro()) {
                    $this->setIdCompra($idCompra);
                    $this->setCoFecha($compra['coFecha']);
                    //Creo un objeto para buscar al id y setear el objeto
                    $objUsuario = new Usuario();
                    $objUsuario->buscar($compra['idUsuario']);
                    $this->setObjUsuario($objUsuario);
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
        $arrayCompra = null;
        $base = new baseDatos();
        $consultaCompra =  "SELECT * from compra";
        if ($condicion != '') {
            $consultaCompra = $consultaCompra . ' WHERE ' . $condicion;
        }
        $consultaCompra.=" ORDER BY idCompra ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCompra)) {
                $arrayCompra = array();
                while ($compra = $base->Registro()) {
                    $objCompra = new Compra();
                    $objCompra->buscar($compra['idCompra']);
                    array_push($arrayCompra, $objCompra);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }

        return $arrayCompra;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compra WHERE idCompra = ". $this->getIdCompra();
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
            "ID de compra: " . $this->getIdCompra() .
            "\n Fecha de compra: " . $this->getCoFecha() .
            "\n ID del usuario que realizó la compra: " . $this->getObjUsuario()->getIdUsuario() . "\n");
    }

    public function ultimaCompra(){
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "SELECT * FROM compra WHERE  idcompra in (SELECT MAX(idcompra) AS idcompra FROM compra)";
            if ($base->Ejecutar($consulta)) {
                if ($compra = $base->Registro()) {
                    $this->setIdCompra($compra['idCompra']);
                    $this->setCoFecha($compra['coFecha']);
                    //Creo un objeto para buscar al id y setear el objeto
                    $objUsuario = new Usuario();
                    $objUsuario->buscar($compra['idUsuario']);
                    $this->setObjUsuario($objUsuario);
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
}
?>

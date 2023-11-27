<?php
//TERMINADO (ver situación de modificar)
class CompraItem extends baseDatos
{
    private $idCompraItem;
    private $objProducto;
    private $objCompra;
    private $ciCantidad;
    private $mensajeFuncion;
    public function __construct()
    {
        $this->idCompraItem = "";
        $this->objProducto = new Producto();
        $this->objCompra = new Compra();
        $this->ciCantidad = "";
    }

    public function cargar($idCompraItem, $objProducto, $objCompra, $ciCantidad)
    {
        $this->setIdCompraItem($idCompraItem);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
        $this->setCiCantidad($ciCantidad);
    }

    //Metodos de acceso

    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;
    }

    public function getObjProducto()
    {
        return $this->objProducto;
    }

    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;
    }

    public function getObjCompra()
    {
        return $this->objCompra;
    }

    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }

    public function getCiCantidad()
    {
        return $this->ciCantidad;
    }

    public function setCiCantidad($ciCantidad)
    {
        $this->ciCantidad = $ciCantidad;
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
        $objCompra = $this->getObjCompra();
        $objProducto = $this->getObjProducto();

        //Creo la consulta 
        $consulta = "INSERT INTO compraitem (idCompraItem, idProducto, idCompra, ciCantidad) VALUES (
         DEFAULT ,
        {$objProducto->getIdProducto()},
        {$objCompra->getIdCompra()},
        {$this->getCiCantidad()})";
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
        $consulta = "UPDATE compraitem 
        SET idProducto= " . $this->getObjProducto()->getIdProducto() . ",
        idCompra= " . $this->getObjCompra()->getIdCompra() . ",
        ciCantidad= " . $this->getCiCantidad() . " 
        WHERE idCompraItem= " . $this->getIdCompraItem();
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
    public function buscar($idCompraItem)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM compraitem WHERE idCompraItem =" . $idCompraItem;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($item = $base->Registro()) {
                    $this->setIdCompraItem($idCompraItem);
                    //Creo un objeto para buscar al id y setear el objeto
                    $objProducto = new Producto();
                    $objProducto->buscar($item['idProducto']);
                    $this->setObjProducto($objProducto);
                    $objCompra = new Compra();
                    $objCompra->buscar($item['idCompra']);
                    $this->setObjCompra($objCompra);
                    $this->setCiCantidad($item['ciCantidad']);
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
        $arrayCompraItem = null;
        $base = new baseDatos();
        $consultaItem =  "SELECT * from compraitem";
        if ($condicion != '') {
            $consultaItem = $consultaItem . ' WHERE ' . $condicion;
        }
        $consultaItem .= " ORDER BY idCompraItem ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaItem)) {
                $arrayCompraItem = array();
                while ($item = $base->Registro()) {
                    $objCompraItem = new CompraItem();
                    $objCompraItem->buscar($item['idCompraItem']);
                    array_push($arrayCompraItem, $objCompraItem);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arrayCompraItem;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compraitem WHERE idCompraItem = " . $this->getIdCompraItem();
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
            "ID de compra-item: " . $this->getIdCompraItem() .
            "\n ID del producto: " . $this->getObjProducto()->getIdProducto() .
            "\n ID de compra: " . $this->getObjCompra()->getIdCompra() .
            "\n Cantidad de compra-item: " . $this->getCiCantidad() . "\n");
    }
}
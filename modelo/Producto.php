<?php
//TERMINADO (ver situación de modificar)
class Producto extends baseDatos{
    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $proPrecio;
    private $urlItem;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idProducto = "";
        $this->proNombre = "";
        $this->proDetalle = "";
        $this->proCantStock = "";
        $this->proPrecio = "";
        $this->urlItem = "";
    }

    public function cargar($idProducto, $proNombre, $proDetalle, $proCantStock, $proPrecio, $urlItem)
    {
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setProCantStock($proCantStock);
        $this->setProPrecio($proPrecio);
        $this->setUrlItem($urlItem);
    }

    //Metodos de acceso

    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function getProNombre()
    {
        return $this->proNombre;
    }

    public function setProNombre($proNombre)
    {
        $this->proNombre = $proNombre;
    }

    public function getProDetalle()
    {
        return $this->proDetalle;
    }

    public function setProDetalle($proDetalle)
    {
        $this->proDetalle = $proDetalle;
    }

    public function getProCantStock()
    {
        return $this->proCantStock;
    }

    public function setProCantStock($proCantStock)
    {
        $this->proCantStock = $proCantStock;
    }

    public function getProPrecio()
    {
        return $this->proPrecio;
    }

    public function setProPrecio($proPrecio)
    {
        $this->proPrecio = $proPrecio;
    }

    public function getUrlItem()
    {
        return $this->urlItem;
    }

    public function setUrlItem($urlItem)
    {
        $this->urlItem = $urlItem;
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
    public function insertar(){
        $base = new baseDatos();
        $resp = false;
        
        //Creo la consulta 
        $consulta = "INSERT INTO producto (idProducto, proNombre, proDetalle, proCantStock, proPrecio, urlItem) VALUES ('".$this->getIdProducto()."', 
        '".$this->getProNombre()."',
        '".$this->getProDetalle()."',
        '".$this->getProCantStock()."',
        '".$this->getProPrecio()."',
        '".$this->getUrlItem()."')";
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
    public function modificar(){
        $base = new baseDatos();
        $resp = false;
        $consulta = "UPDATE producto SET 
        proNombre = '".$this->getProNombre()."',
        proDetalle = '".$this->getProDetalle()."',
        proCantStock = '".$this->getProCantStock()."', 
        proPrecio = '".$this->getProPrecio()."',
        urlItem = '".$this->getUrlItem()."'
        WHERE 
        idProducto = ". $this->getIdProducto();
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
    public function buscar($idProducto){
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM producto WHERE idProducto = '" . $idProducto . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($producto = $base->Registro()) {
                    $this->setIdProducto($idProducto);
                    $this->setProNombre($producto['proNombre']);
                    $this->setProDetalle($producto['proDetalle']);
                    $this->setProCantStock($producto['proCantStock']);
                    $this->setProPrecio($producto['proPrecio']);
                    $this->setUrlItem($producto['urlItem']);
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
        $arrayProductos = null;
        $base = new baseDatos();
        $consultaProducto =  "SELECT * from producto";
        if ($condicion != '') {
            $consultaProducto = $consultaProducto . ' WHERE ' . $condicion;
        }
        $consultaProducto.=" ORDER BY idProducto ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaProducto)) {
                $arrayProductos = array();
                while ($producto = $base->Registro()) {
                    $objProducto = new Producto();
                    $objProducto->buscar($producto['idProducto']);
                    array_push($arrayProductos, $objProducto);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }

        return $arrayProductos;
    }

    //ELIMINAR
    public function eliminar(){
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()){
            $consulta = "DELETE FROM producto WHERE idProducto = " . $this->getIdProducto();
            if ($base->Ejecutar($consulta)) {
                $resp = true;
            } 
            else{
                $this->setMensajeFuncion($base->getError());
            }
        }
        else{
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function __toString(){
        return (
            "ID del producto: " . $this->getIdProducto() .
            "\n Nombre del producto: " . $this->getProNombre() .
            "\n Detalles: " . $this->getProDetalle() .
            "\n Cantidad en Stock: " . $this->getProCantStock() .
            "\n Precio: " . $this->getProPrecio() . "\n");
    }
}

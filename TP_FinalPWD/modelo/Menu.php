<?php
class Menu extends baseDatos{
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre; 
    private $meDeshabilitado;
    private $mensajeFuncion;

    public function __construct()
    {
        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->idPadre = '';
        $this->meDeshabilitado = "";
    }

    public function cargar($idMenu, $meNombre, $meDescripcion, $idPadre, $meDeshabilitado)
    {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setIdPadre($idPadre);
        $this->setMensajeFuncion($meDeshabilitado);
    }

    public function getIdMenu(){
        return $this->idMenu;
    }

    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }

    public function getMeNombre(){
        return $this->meNombre;
    }

    public function setMeNombre($meNombre){
        $this->meNombre = $meNombre;
    }

    public function getMeDescripcion(){
        return $this->meDescripcion;
    }

    public function setMeDescripcion($meDescripcion){
        $this->meDescripcion = $meDescripcion;
    }

    public function getIdPadre(){
        return $this->idPadre;
    }

    public function setIdPadre($idPadre){
        $this->idPadre = $idPadre;
    }

    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }

    public function setMeDeshabilitado($meDeshabilitado){
        $this->meDeshabilitado = $meDeshabilitado;
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
        $consulta = "INSERT INTO menu (idMenu, meNombre, meDescripcion, idPadre, meDeshabilitado) VALUES (
        '".$this->getIdMenu()."',
         '".$this->getMeNombre()."',
        '".$this->getMeDescripcion()."',
        '".$this->getIdPadre()."',
        '".$this->getMeDeshabilitado()."')"; 
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
        
        $consulta = "UPDATE menu 
        SET
        meNombre = '".$this->getMeNombre()."',
        meDescripcion = '".$this->getMeDescripcion()."',
        idPadre = '".$this->getIdPadre()."',
        meDeshabilitado = ".$this->getMeDeshabilitado()."
        WHERE idMenu = ". $this->getIdMenu();
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
    public function buscar($idMenu)
    {
        $base = new baseDatos();
        $resp = false;
        $consulta = "SELECT * FROM menu WHERE idMenu = " . $idMenu;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($menu = $base->Registro()) {
                    $this->setIdMenu($idMenu);
                    $this->setMeNombre($menu['meNombre']);
                    $this->setMeDescripcion($menu['meDescripcion']);
                    $this->setIdPadre($menu['idPadre']);
                    $this->setMeDeshabilitado($menu['meDeshabilitado']);
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
        $arrayMenu = null;
        $base = new baseDatos();
        $consultaMenu =  "SELECT * from menu ";
        if ($condicion != '') {
            $consultaMenu = $consultaMenu . ' WHERE ' . $condicion;
        }
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaMenu)) {
                $arrayMenu = array();
                while ($menu = $base->Registro()) {
                    $objMenu = new Menu();
                    $objMenu->buscar($menu['idMenu']);
                    array_push($arrayMenu, $objMenu);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }

        return $arrayMenu;
    }

    //ELIMINAR
    public function eliminar()
    {
        $base = new baseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM menu WHERE idMenu = " . $this->getIdMenu();
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
            "ID menu: " . $this->getIdMenu() .
            "\n Nombre del menu: " . $this->getMeNombre() .
            "\n Descripcion del menu: " . $this->getMeDescripcion() .
            "\n ID del padre: " . $this->getIdPadre() .
            "\n Menu deshabilitado: " . $this->getMeDeshabilitado() . "\n");
    }
}
<?php
//HAY QUE CAMBIARLO - QUE ES ESTO????????????
trait Condicion{
    //Metodo publico general
    public function SB($arrayBusqueda){
        $stringBusqueda = '';
        if (count($arrayBusqueda) > 0) {
            foreach ($arrayBusqueda as $key => $value) {
                if ($value != null || $key == 'usDeshabilitado' || $key == 'proDeshabilitado' || $key == 'meDeshabilitado' || $key == 'cefechafin') {
                    if ($key == 'usDeshabilitado' || $key == 'proDeshabilitado' || $key == 'meDeshabilitado' || $key == 'cefechafin') {
                        $string = " $key IS NULL ";
                    } else {
                        $string = " $key = '$value' ";
                    }
                    if ($stringBusqueda == '') {
                        $stringBusqueda.=$string;
                    } else {
                        $stringBusqueda.= ' and ';
                        $stringBusqueda.= $string;
                    }
                }
            }
        }
        return $stringBusqueda;
    }
}
?>
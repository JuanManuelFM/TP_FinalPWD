<?php
include_once("../menu/cabecera.php");
    $objMenu= new C_menu();
    $arrayMenues = $objMenu->listar('');
    if ($arrayMenues != null) {
        $cantMenues = count($arrayMenues);
        // $rolesDesc = $objUsuarioRol->darDescripcionRoles($arrayUsuarios);
    } else {
        $cantMenues = -1;
    }
    $i = 0;
?>
<!-- <body> -->
<div class="container-fluid height-full" style="background-color:brown;">
        <div class="container col-md-10">
            <h2>Lista de todos los menús</h2>
            <div class="mb-3">
                <table class="table table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>Nombre Menu</th>
                            <th>Rol asociado</th>
                            <th>Estado actual</th>
                            <th>Deshabilitar</th>
                            <th>Habilitar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(isset($arrayMenues)){ //isset se fija si la variable tiene algo
                        foreach ($arrayMenues as $menu){ 
                            echo '<tr>';
                            echo '<td>'. $menu->getMeNombre().'</td>';
                            echo '<td>'. $menu->getMeDescripcion().'</td>';
                            echo '<td>'. $menu->getMeDeshabilitado().'</td>';
                            echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                            echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>';
                            echo '</tr>';               
                            }
                        }else{
                            echo '<p class="lead"> Actualmente no hay menús registrados </p>';
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
<!-- </body> -->
<!-- </html> -->
<script src="js/deshabilitarUsuario.js"></script>
<script src="js/habilitarUsuario.js"></script>
<?php
    include_once("../menu/pie.php");
?>
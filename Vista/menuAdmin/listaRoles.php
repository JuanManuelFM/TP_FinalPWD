<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$objRol = new c_rol();
$arrayRoles = $objRol->buscar(); 
if ($objSession->getVista() != null && $objSession->getVista() == 1) {
    if ($arrayRoles != null) {
        $cantRoles = count($arrayRoles);
        // $rolesDesc = $objUsuarioRol->darDescripcionRoles($arrayUsuarios);
    } else {
        $cantRoles = -1;
    }
    $i = 0;
?>
    <!-- <style>
    body {
        background-color: #E47070;
    }
</style> -->
    <div class="container-fluid" style="margin-top: 25px;">
        <div class="container col-md-12">
            <h2>Lista de todos los menues</h2><button class="btn btn-primary mt-1 col-2" name="boton_crearRol" id="boton_crearRol">Crear Rol</button>
            <br>
            <div class="container text-black mt-3 d-none" id='crearRol'>
                <h2>Ingrese los datos:</h2>
                <div class="mb-3">
                    <form id='form-crearRol' method="post" action="../accion/accionCrearRol.php" class="needs-validation row text-white justify-content-center col-12" novalidate>
                        <table class="table table-striped table-secondary">
                            <tr>
                                <th>Nombre del Rol:</th>
                            </tr>
                            <tr>
                                <td>
                                    <input id="rolDescripcion"  type="text">
                                </td>
                            </tr>
                        </table>
                        <input class="btn btn-success mt-2 col-3" type="submit" name="boton_enviar" id="boton_enviar" value="GUARDAR">
                        <input class="btn btn-danger mx-4 mt-2 col-3" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
                    </form>
                </div>
            </div>
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th>IdRol</th>
                        <th>Nombre Rol</th>
                        <th>Editar</th>
                        <!-- <th>Deshabilitar</th>
                        <th>Habilitar</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($arrayRoles)) { //isset se fija si la variable tiene algo
                        foreach ($arrayRoles as $rol) {
                            echo '<tr class="align-middle text-center">';
                            echo '<td>' . $rol->getIdRol() . '</td>';
                            echo '<td>' . $rol->getRolDescripcion() . '</td>';
                            echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Rol</button>';
                            /* echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                            echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>'; */
                            echo '</tr>';
                        }
                    } else {
                        echo '<p class="lead"> Actualmente no hay roles registrados </p>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifique datos rol</h5>
                </div>
                <div class="modal-body">
                    <form id="actualizaRol" action="accionActualizarRol.php" class="needs-validation" method="POST">
                        <input type="hidden" name="idRol" id="idRol" value="<?= $rol->getIdRol() ?>">
                        <div class="form-group" style="margin-bottom: 10px ;">
                            <label>Nombre Rol</label>
                            <input type="text" name="rolDescripcion" id="rolDescripcion" class="form-control" placeholder="Ingrese nuevo nombre de rol" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="actualizaRol" name="insertData" class="btn btn-primary actualizar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<script src="js/actualizarRol.js"></script>
<script src="js/crearRol.js"></script>
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
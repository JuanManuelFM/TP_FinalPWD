<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
/* $objRol = new c_menuRol();
$arrayRoles = $objRol->listar(''); */
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
            <h2>Lista de todos los menues</h2>
            <br>
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
                            echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Menu</button>';
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
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
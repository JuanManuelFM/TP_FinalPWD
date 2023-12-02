<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$objMenu = new C_menu();
$arrayMenues = $objMenu->listar('');
$rolController = new c_rol();
$roles = $rolController->buscar();
if ($objSession->getVista() != null && $objSession->getVista() == 1) {
    if ($arrayMenues != null) {
        $cantMenues = count($arrayMenues);
        // $rolesDesc = $objUsuarioRol->darDescripcionRoles($arrayUsuarios);
    } else {
        $cantMenues = -1;
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
                        <th>Nombre Menu</th>
                        <!-- <th>Rol asociado</th> -->
                        <th>Estado actual</th>
                        <th>Editar</th>
                        <th>Deshabilitar</th>
                        <th>Habilitar</th>
                        <!-- $param['idMenu'],
                            $param['meNombre'],
                            $param['meDescripcion'],
                            $padre,
                            $param['meDeshabilitado'], -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($arrayMenues)) { //isset se fija si la variable tiene algo
                        foreach ($arrayMenues as $menu) {
                    ?>
                            <tr class="align-middle text-center">
                                <td id="nombreMenu<?= $menu->getIdMenu() ?>"><?= $menu->getMeNombre() ?></td>
                                <td id="deshabilitadoMenu<?= $menu->getIdMenu() ?>"><?= $menu->getMeDeshabilitado() ?></td>
                                <td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal" data-bs-target="#editModal<?= $menu->getIdMenu() ?>" data-bs-whatever="@mdo">Editar Menu</button>
                                <td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>
                                <td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>
                            </tr>
                            <div class="modal fade" id="editModal<?= $menu->getIdMenu() ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modifique datos menu</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="actualizaMenu" action="accionActualizarMenu.php" class="needs-validation" method="POST">
                                                <input type="hidden" name="idMenu" id="idMenu" value="<?= $menu->getIdMenu() ?>">
                                                <input type="hidden" name="meDescripcion" id="meDescripcion" value="<?= $menu->getMeDescripcion() ?>">
                                                <input type="hidden" name="idPadre" id="idPadre" value="<?= $menu->getIdPadre() ?>">
                                                <input type="hidden" name="meDeshabilitado" id="meDeshabilitado" value="<?= $menu->getMeDeshabilitado() ?>">
                                                <div class="form-group" style="margin-bottom: 10px ;">
                                                    <label>Nombre Menu</label>
                                                    <input type="text" name="meNombre" value="<?= $menu->getMeNombre() ?>" id="meNombre" class="form-control" placeholder="Ingrese nuevo nombre de menu" required>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" form="actualizaMenu" name="insertData" class="btn btn-primary actualizar">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p class="lead"> Actualmente no hay menús registrados </p>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="./js/deshabilitarMenu.js"></script>
    <script src="./js/habilitarMenu.js"></script>
    <!-- <script src="./js/actualizarMenu.js"></script> -->
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
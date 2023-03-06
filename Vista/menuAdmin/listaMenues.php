<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
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
<style>
    body{
        background-color: #E47070;
    }
</style>
<div class="container-fluid" style="margin-top: 30px;">
    <div class="container col-md-12">
        <h2>Lista de todos los usuarios</h2>
        <br>
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th>Nombre Menu</th>
                    <th>Rol asociado</th>
                    <th>Estado actual</th>
                    <th>Editar</th>
                    <th>Deshabilitar</th>
                    <th>Habilitar</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (isset($arrayMenues)) { //isset se fija si la variable tiene algo
                    foreach ($arrayMenues as $menu) {
                        echo '<tr>';
                        echo '<td>'. $menu->getMeNombre().'</td>';
                        echo '<td>'. $menu->getMeDescripcion().'</td>';
                        echo '<td>'. $menu->getMeDeshabilitado().'</td>';
                        echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Menu</button>';
                        echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                        echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<p class="lead"> Actualmente no hay menús registrados </p>';
                }
?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role= "document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifique datos menu</h5>
            </div>
            <div class="modal-body">
                <form id="actualizaUsuario" action="accionActualizarUsuario.php" class="needs-validation" method="POST">
                    <input type="hidden" name="idMenu" id="idMenu">
                    <input type="hidden" name="meDescripcion" id="meDescripcion">
                    <input type="hidden" name="idPadre" id="idPadre">
                    <input type="hidden" name="meDeshabilitado" id="meDeshabilitado">
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Nombre Menu</label>
                        <input type="text" name="meNombre" id="meNombre" class="form-control" placeholder="Ingrese nuevo nombre de menu" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Rol con acceso</label>
                        <input type="checkbox" name="meRol" id="meRol1" class="form-control">
                        <input type="checkbox" name="meRol" id="meRol2" class="form-control">
                        <input type="checkbox" name="meRol" id="meRol3" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="actualizaUsuario" name="insertData" class="btn btn-primary actualizar">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script src="js/deshabilitarUsuario.js"></script>
<script src="js/habilitarUsuario.js"></script>
<?php
    include_once("../menu/pie.php");
?>
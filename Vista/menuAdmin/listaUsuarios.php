<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
$objControlUsuario = new c_usuario();
$arrayUsuarios = $objControlUsuario->listar('');
$objUsuarioRol = new c_usuarioRol();
if($objSession->getVista() != null && $objSession->getVista() == 1) {
    if ($arrayUsuarios != null) {
        $cantUsuarios = count($arrayUsuarios);
    } else {
        $cantUsuarios = -1;
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
        <h2>Lista de todos los usuarios</h2>
        <br>
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th>ID usuario</th>
                    <th>Usuario</th>
                    <th>Mail Usuario</th>
                    <th>Roles</th>
                    <th>Estado actual</th>
                    <th>Editar Usuario</th>
                    <th>Deshabilitar</th>
                    <th>Habilitar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($arrayUsuarios)) { //isset se fija si la variable tiene algo
                        foreach ($arrayUsuarios as $usuario) {
                            echo '<tr class="align-middle text-center">';
                            echo '<td>' . $usuario->getIdUsuario() . '</td>';
                            echo '<td>' . $usuario->getUsNombre() . '</td>';
                            echo '<td>' . $usuario->getUsMail() . '</td>';
                            echo '<td>';
                            $sepRoles = "";
                            $usRol = $objUsuarioRol->buscar(['idUsuario' => $usuario->getIdUsuario()]);
                            foreach ($usRol as $rol) {
                                //para no hacer salto de linea extra (if)
                                $sepRoles .= $rol->getObjRol()->getRolDescripcion();
                                if($rol->getObjRol()->getRolDescripcion() != end($usRol)->getObjRol()->getRolDescripcion()) {
                                    $sepRoles .= '<br>';
                                } 
                            }
                            echo $sepRoles . '</td>';
                            echo '<td>' . $usuario->getUsDeshabilitado() . '</td>';
                            echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Usuario</button>';
                            echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                            echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<p class="lead"> Actualmente no hay personas registradas </p>';
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
                <h5 class="modal-title" id="exampleModalLabel">Modifique datos usuario</h5>
            </div>
            <div class="modal-body">
                <form id="actualizaUsuario" action="accionActualizarUsuario.php" class="needs-validation" method="POST">
                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?= $usuario->getIdUsuario() ?>">
                    <input type="hidden" name="usPass" id="usPass" value="<?= $usuario->getUsPass() ?>">
                    <input type="hidden" name="usDeshabilitado" id="usDeshabilitado" value="<?= $usuario->getUsDeshabilitado() ?>">
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Nombre Usuario</label>
                        <input type="text" name="usNombre" id="usNombre" class="form-control" placeholder="Ingrese nuevo nombre de usuario" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px ;">
                        <label>Mail Usuario</label>
                        <input type="email" name="usMail" id="usMail" class="form-control" placeholder="Ingrese nuevo mail del usuario" required>
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
<script src="js/actualizarUsuario.js"></script>
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php")
?>
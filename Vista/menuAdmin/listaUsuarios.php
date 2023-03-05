<?php
include_once("../menu/cabecera.php");
include_once("../../configuracion.php");
    $objControlUsuario = new c_usuario();
    $arrayUsuarios = $objControlUsuario->listar('');
    $objUsuarioRol = new c_usuarioRol();
    if ($arrayUsuarios != null) {
        $cantUsuarios = count($arrayUsuarios);
    } else {
        $cantUsuarios = -1;
    }
    $i = 0;
?>

<div class="container-fluid height-full" style="background-color:brown;">
            <div class="container col-md-10">
                <br>
                <h2>Lista de todos los usuarios</h2>
                <div class="mb-3">
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
                            if(isset($arrayUsuarios)){ //isset se fija si la variable tiene algo
                                foreach ($arrayUsuarios as $usuario){ 
                                    echo '<tr>';
                                    echo '<td>'. $usuario->getIdUsuario().'</td>';
                                    echo '<td>'. $usuario->getUsNombre().'</td>';
                                    echo '<td>'. $usuario->getUsMail().'</td>';
                                    echo '<td>';
                                    $sepRoles = "-";
                                    $usRol= $objUsuarioRol->buscar(['idUsuario' => $usuario->getIdUsuario()]);
                                    foreach ($usRol as $rol) {
                                        $sepRoles = $rol->getObjRol()->getRolDescripcion() . "-";
                                    }
                                    echo $sepRoles . '</td>';
                                    echo '<td>'. $usuario->getUsDeshabilitado().'</td>';
                                    echo '<td><button type="button" class="btn btn-success editarBoton" data-bs-toggle="modal"data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar Usuario</button>';
                                    echo '<td><button type="button" class="btn btn-warning remove">Deshabilitar</button></td>';
                                    echo '<td><button type="button" class="btn btn-warning unRemove">Habilitar</button></td>';
                                    echo '</tr>';
                                }
                            }else{
                                echo '<p class="lead"> Actualmente no hay personas registradas </p>';
                            }
                            ?>
                </div>
            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role= "document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modifique datos usuario</h5>
                                </div>

                                <form action="accionActualizarUsuario.php" class="needs-validation" method="POST">

                                <div class="modal-body">
                                    <input type="hidden" name="idUsuario" id="idUsuario">
                                    <input type="hidden" name="usPass" id="usPass">
                                    <input type="hidden" name="usDeshabilitado" id="usDeshabilitado">
                                    <div class="form-group" style="margin-bottom: 10px ;">
                                        <label>Nombre Usuario</label>
                                        <input type="text" name="usNombre" id="usNombre" class="form-control" placeholder="Ingrese nuevo nombre de usuario" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 10px ;">
                                        <label>Mail Usuario</label>
                                        <input type="email" name="usMail" id="usMail" class="form-control" placeholder="Ingrese nuevo mail del usuario" required>
                                    </div>
                                    <!-- div class="form-group" style="margin-bottom: 10px ;">
                                        <label>Roles Usuario</label>
                                        <br>
                                        <label>Rol Administrador<input type="checkbox" id="cbox1" value="rolAdmin"></label>
                                        <br>
                                        <label>Rol Cliente<input type="checkbox" id="cbox2" value="rolCliente"></label>
                                        <br>
                                        <label>Rol Deposito<input type="checkbox" id="cbox3" value="rolDepo"></label>
                                    </div> -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="insertData" class="btn btn-primary actualizar">Guardar</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>

</div>
<!-- </body> -->
<script src="js/deshabilitarUsuario.js"></script>
<script src="js/habilitarUsuario.js"></script>
<script src="js/actualizarUsuario.js"></script>
<!-- </html> -->
<?php
    include_once("../menu/pie.php");
?>
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
            <h2>Lista de todos los menues</h2> <button class="btn btn-primary mt-1 col-2" name="boton_crearMenu" id="boton_crearMenu">Crear Menú</button>
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
                                <td><button type="button" class="btn btn-warning removeMenu">Deshabilitar</button></td>
                                <td><button type="button" class="btn btn-warning unRemoveMenu">Habilitar</button></td>
                            </tr>
                            <div class="modal fade" id="editModal<?= $menu->getIdMenu() ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modifique datos menu</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="actualizaMenu" class="needs-validation" method="POST">
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

    <div class="container text-white mt-5 d-none" id='crearMenu'>
        <h2>Ingrese los datos:</h2>
        <div class="mb-3">
        <form  id='form-crearMenu' method="post" action="../accion/accionCrearMenu.php"class="needs-validation row text-white justify-content-center col-12" novalidate>
                <table class="table table-striped table-secondary">
                    <tr> 
                        <th>Nombre del menu:</th>
                        <th>Descripcion (ruta):</th>
                        <th>Id padre:</th>
                        <th>Roles con acceso:</th>
                    </tr>
                    <tr>
                        <td>
                            <!-- <div class="col-lg-7 col-12"><?php echo $usuario->getUsNombre()?></div> -->
                            <div class="col-lg-7 col-12">
                                <input value = '<?php echo $usuario->getUsNombre()?>' type="text" style="width: 150px;" pattern="[a-zA-Z]+\s?[0-9]*" name="usNombre" value="usNombre"></input>
                                <!-- Para que es el de abajo????????? -->
                                <input name="type" value="username" class="d-none"/>
                            </div>
                            <!-- <div class="col-lg-7 col-12 d-none">
                                <input value = '<?php echo $usuario->getUsPass()?>' type="text" name="usPass"></input>
                            </div> -->
                        </td>
                        <td>
                            <div class="col-lg-7 col-12 "><input value = '<?php echo $usuario->getUsMail()?>' type="email" style="width: 250px;" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.([a-z]{3})(\.[a-z]{2})*$" name="usMail" value="usMail" required></input><div class="invalid-feedback">
                            Ingrese un email valido!</div>
                            <div class="valid-feedback">
                            Correcto!</div></div><div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getIdUsuario()?>' type="number"  name="idUsuario" required></input></div>
                        </td>
                    </tr>
                </table>
                <input class="btn btn-success mt-2 col-3" type="submit" name="boton_enviar"  id="boton_enviar" value="GUARDAR">
                <input class="btn btn-danger mx-4 mt-2 col-3" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
            </form>
        </div>
    </div>
   
    <script>
    $(document).on('click', '.removeMenu', function() {
    var fila = $(this).closest('tr');
    // console.log(fila[0].children[0].id.substring(10));
    console.log("holis");
    $.ajax({
        type: "POST",
        url: 'accion/accionDeshabilitarMenu.php',
        data: { idMenu: fila[0].children[0].innerHTML },
        success: function (respuesta) {
            var jsonData = JSON.parse(respuesta);
            // user is logged in successfully in the back-end
            // let's redirect
            if (jsonData.success == "1") {
                registerSuccessD();
            }
            else if (jsonData.success == "0") {
                console.log("falla");
                registerFailureD();
            }
        }
    });
});
    </script>
    <script src="js/habilitarMenu.js"></script>
    <!-- <script src="js/crearMenu.js"></script> -->
    <script src="js/actualizarMenu.js"></script> 
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
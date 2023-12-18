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
    <div class="container-fluid" style="margin-top: 25px;">
        <div class="container col-md-12">
            <h2>Lista de todos los menues</h2> <button class="btn btn-primary mt-1 col-2" name="boton_crearMenu" id="boton_crearMenu">Crear Menú</button>
            <br>
            <div class="container text-white mt-5 d-none" id='crearMenu'>
                <h2>Ingrese los datos:</h2>
                <div class="mb-3">
                    <form id='form-crearMenu' method="post" action="../accion/accionCrearMenu.php" class="needs-validation row text-white justify-content-center col-12" novalidate>
                        <table class="table table-striped table-secondary">
                            <tr>
                                <th>Nombre del menu:</th>
                                <th>Descripcion (ruta):</th>
                                <!-- <th>Id padre:</th> -->
                                <th>Roles con acceso:</th>
                            </tr>
                            <tr>
                                <td>
                                    <input id="meNombre"  type="text">
                                </td>
                                <td>
                                    <input id="meDescripcion" type="text" placeholder="../menu(Admin-Cliente-Depo)/script.php">
                                </td>
                                <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Administrador
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Cliente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="3">
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Deposito
                                    </label>
                                </div>
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
                                <td><button type="button" class="btn btn-warning removeMenu" onclick="handleClickDeshabilitar(<?= $menu->getIdMenu() ?>)">Deshabilitar</button></td>
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

    <script src="js/crearMenu.js"></script>
    <script src="js/actualizarMenu.js"></script>
    <script>
        function handleClickDeshabilitar(idMenu) {
            $.ajax({
                type: "POST",
                url: 'accion/accionDeshabilitarMenu.php',
                data: {
                    idMenu
                },
                success: function(respuesta) {
                    var jsonData = JSON.parse(respuesta);
                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        registerSuccessD();
                    } else if (jsonData.success == "0") {
                        console.log("falla");
                        registerFailureD();
                    }
                }
            });
        }

        function registerSuccessD() {
            Swal.fire({
                icon: 'success',
                title: 'El menú se ha deshabilitado correctamente!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout(function() {
                recargarPagina();
            }, 1500);
        }

        function registerFailureD() {
            Swal.fire({
                icon: 'error',
                title: 'No se ha podido deshabilitado el menú!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout(function() {
                recargarPagina();
            }, 1500);
        }

        function recargarPagina() {
            location.reload();
        }

        function registerSuccessUnRemove() {
            Swal.fire({
                icon: 'success',
                title: 'El menú se ha habilitado correctamente!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout(function() {
                recargarPagina();
            }, 1500);
        }

        function registerFailureUnRemove() {
            Swal.fire({
                icon: 'error',
                title: 'No se ha podido habilitar el menú!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout(function() {
                recargarPagina();
            }, 1500);
        }

        $(document).on('click', '.unRemoveMenu', function() {
            var fila = $(this).closest('tr');
            console.log(fila[0].children[0].id.substring(10));
            $.ajax({
                type: "POST",
                url: 'accion/accionHabilitarMenu.php',
                data: {
                    idMenu: fila[0].children[0].id.substring(10)
                },
                success: function(respuesta) {
                    var jsonData = JSON.parse(respuesta);
                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1") {
                        registerSuccessUnRemove();
                    } else if (jsonData.success == "0") {
                        registerFailureUnRemove();
                    }
                }
            });
        });
    </script>
    <!-- <script src="js/habilitarMenu.js"></script> -->
<?php
} else {
    header('Location: ../../index.php');
}
include_once("../menu/pie.php");
?>
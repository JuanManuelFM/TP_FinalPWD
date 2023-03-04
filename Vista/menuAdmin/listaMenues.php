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
    <div class="container-fluid mx-auto m-5">
    <?php
        // if ($cantPermisos > -1) {
    ?>
        <div class="container col-md-10">
            <h2>Lista de todos los menús</h2>
            <div class="mb-3">
                <table class="table table-hover p-5">
                    <thead class="text-center">
                        <tr>
                            <th>ID Menu</th>
                            <th>Nombre Menu</th>
                            <th>Ruta</th>
                            <th>ID Rol</th>
                            <th>Mail Usuario</th>
                            <th>Rol</th>
                            <th>Habilitado</th>
                            <th>Acciones</th>
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
                            echo '<td>'. $menu->getIdPadre().'</td>';
                            echo '</tr>';                   
                            }
                        }else{
                            echo '<p class="lead"> Actualmente no hay menús registrados </p>';
                        }
                            ?>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Message:</label>
                                        <textarea class="form-control" id="message-text"></textarea>
                                    </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Send message</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
<!-- </body> -->
<!-- </html> -->
<?php
    include_once("../menu/pie.php");
?>
<?php
include_once ("../../configuracion.php");
include_once ("../menu/cabecera.php");
if($objSession->getVista()!= null && $objSession->getVista() == 2){
    $datos['usNombre'] = $objSession->getUsNombre();
    $usuario = new c_usuario;
    $usuario = $usuario->buscar($datos)[0];
?>
    <div class="container mt-5 ">
        <h2>Mis Datos:</h2>
        <div class="mb-3">
            <h5 class="text-black">Nombre de usuario: <?= $usuario->getUsNombre() ?> <button class="btn btn-secondary mt-2 col-3" name="boton_editarDatos" id="boton_editarDatos">Editar</button></h5>
            <h5 class="text-black">Email: <?= $usuario->getUsMail() ?></h5>
            <button class="btn btn-warning" id="boton_contra">Editar Contraseña</button>
        </div>
    </div>

    <div class="container text-white mt-5 d-none" id='editarDatos'>
        <h2>Editar Datos:</h2>
        <div class="mb-3">
        <form  id='form-editar' method="post" action="../accion/accionActualizarPerfil.php"class="needs-validation row text-white justify-content-center col-12" novalidate>
                <table class="table table-striped table-secondary">
                    <tr> 
                        <th>Nombre de usuario:</th>
                        <th>Email:</th>
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

    <div class="container-fluid col-md-9 text-white mt-5 d-none" id='editarContraseña'>
        <h2>Cambiar Contraseña:</h2>
        <div class="mb-3">
            <form  id='form-contraseña' method="post" action="../Accion/accionActualizarPerfil.php"class="needs-validation row text-white justify-content-center col-12" novalidate>
                <input type="text" value="username" class="d-none" id="type">
                <table class="table table-striped table-secondary">
                    <tr>
                        <th>Nombre de usuario</th>
                        <th>Ingrese contraseña actual</th>
                        <th>Ingrese contraseña nueva</th>
                        <th>Confirmar contraseña</th>
                    </tr>
                    <tr>
                    <td ><div class="col-lg-7 col-12"><?php echo $usuario->getUsNombre()?></div>
                        <div class="col-lg-7 col-12 d-none "><input value = '<?php echo $usuario->getUsNombre()?>' type="text" name="usNombre"></input></div>
                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getUsPass()?>' type="text" name="usPass"></input></div>
                    </td>
                    <td>
                        <div class="col-lg-8 col-12"><input type="password" class="form-control" id="usPassVieja" name="usPassVieja" required>
                        <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="valid-feedback password-correcta">
                            Correcto!
                            </div>
                    </div>
                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getUsMail()?>' type="email" name="usMail" ></input></div>
                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getIdUsuario()?>' type="number"  name="idUsuario"></input></div>
                    </td>
                    <td>
                        <div class="col-lg-8 col-12"><input type="password" class="form-control" name="usPassNueva" id="usPassNueva" required>
                            <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="invalid-password" style="display: none; color: red;">
                                Las contraseñas no coinciden
                            </div>
                            <div class="valid-feedback password-correcta">
                                Correcto!
                            </div>
                        </div>
                        <div class="col-10 col-lg-7 d-none"><input type="password" class="form-control" name="usPass" id="usPass">
                        <div class="col-10 col-lg-7 d-none"><input type="text" id="usPassSesion" disabled value='<?php echo $usuario->getUsPass()?>' class="form-control" name="usPassSesion" >
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-8 col-12"><input type="password" id="usPassRep" class="form-control" name="usPassRep" requierd> 
                            <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="invalid-password" style="display: none; color: red;">
                                Las contraseñas no coinciden
                            </div>
                        </div>
                    </td>
                    </tr>
                </table>
                <input class="btn btn-success mt-2 col-3" type="submit" name="boton_enviar"  id="boton_enviar" value="GUARDAR">
                <input class="btn btn-danger mx-4 mt-2 col-3" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
            </form>
        </div>
    </div>
<script src="js/md5.js"></script>
<script src="js/actualizarPerfil.js"></script>

<!-- SE USA????????? -->
<script src="../js/validarContraseñaIguales.js"></script>

<?php
}else{
    header('Location: ../../index.php');
} 
include_once("../menu/pie.php")
?>
<?php
include_once('../../configuracion.php');
// require_once('preCabecera.php');
// include_once('../../Control/C_Session.php'); 
$objSession = new c_session();
$menuRoles = [];
$arrayObjUsuario = $objSession->objUsuarioRegistrado();
if ($arrayObjUsuario != null) {
    $idRoles = $objSession->getRol($arrayObjUsuario[0]);
    $objMenuRol = new c_menuRol();
    $objRol = new c_rol();
    $menuRoles = $objMenuRol->menuesByIdRol($objSession->getVista());
    $objRoles = $objRol->obtenerObj($idRoles);
    /* print_r($objRoles); */
    //ERROR AL ACTUALIZAR USUARIO SE ROMPE PÁGINAS
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP FINAL PWD</title>
    <script src="../jQuery/jquery-3.6.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../alertas/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../alertas/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/genera.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../js/cambiarVista.js"></script>
    <script src="../login/js/cerrarSesion.js"></script>
</head>

<body class="w-100">
        <section class="d-flex flex-column">
            <nav class="navbar navbar-expand-xl navbar-light  barra_navegacion" aria-label="Third navbar example" id="header" style="background: linear-gradient(to right, pink, purple);">
                <div class="container-fluid">
                    <span class="navbar-brand card-title text-light fw-bold text-center" style="font-family: 'Chivo', sans-serif; margin-top: 5px">BeatWorld</span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarsExample03">
                        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                            <li class="nav-item">
                                <a class="px-2 mx-1 btn btn-light  btn-outline-dark" href="../paginaSegura/inicio.php" style="font-family: 'Chivo', sans-serif;">INICIO</a>
                            </li>
                            <!-- aca va todo lo de cambio de menu -->
                            <?php
                        foreach ($menuRoles as $objMenu) {
                            if ($objMenu->getMeDeshabilitado() == null || $objMenu->getMeDeshabilitado() == "0000-00-00 00:00:00") {
                                ?>
                                <li><a href='<?php echo $objMenu->getMeDescripcion() ?>' role="button" class="px-2 mx-1 btn btn-light btn-outline-dark" style="font-family: 'Chivo', sans-serif;"><?php echo $objMenu->getMeNombre() ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <!-- Aca chequeamos que tenga mas de 1 rol para mostrarle el dropdown -->
                    <?php
                    if ($objSession->activa()) {
                        if (count($objRoles) > 1) {
                            $objRolVista = $objRol->obtenerObj([$objSession->getVista()]);
                            ?>
                            <div class="text-end d-flex align-items-center">
                                <select class="form-select form-select-lg me-2" id="cambiar_vista" aria-label=".form-select-lg example">
                                    <option selected disabled><?php echo $objRolVista[0]->getRolDescripcion() ?></option>
                                    <?php
                                    foreach ($objRoles as $objRol) {
                                        ?>
                                        <option value="<?php echo $objRol->getIdRol() ?>"><?php echo $objRol->getRolDescripcion() ?>
                                    </option>
                                    <?php
                                    }
                                }
                                ?>
                                </select>
                                <button type='button' class='px-2 mx-1 btn btn-light btn-outline-dark' style="font-family: 'Chivo', sans-serif;" onclick="cerrarSesion()">SALIR</button>
                                <?php
                        } else {
                            ?>
                                <a class="px-2 mx-1 btn btn-light btn-outline-dark" href="../login/login.php" style="font-family: 'Chivo', sans-serif;">INGRESAR</a>
                                <?php
                        } ?>
                            </div>
                        </div>
            </div>
        </nav>
    </section>
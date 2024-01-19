<?php
include_once("../../configuracion.php");
$objSession= new c_session();
$controllerCompraItem= new c_compraItem();
$idCompra= $_GET["compra"];
/* $compra= $controllerCompraItem->carritoIniciado($objSession->getUsuario()->getIdUsuario())[0];
echo $compra->getObjCompra()->getIdCompra(); */
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP FINAL PWD</title>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../alertas/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../alertas/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/genera.css">
    <script src="../jQuery/jquery-3.6.1.min.js"></script>
</head>
<body>
<div class="card">
    <div class="card-top border-bottom text-center">
        <a href="../PaginaSegura/Inicio.php"> Volver al inicio</a>
    </div>
    <div class="card-body">
        <br>
        <div class="row">
            <form class="pagar">
            <div class="col-md-7">
                <div class="left border">
                    <div class="row">
                        <span class="header">Pago</span>
                        <div class="icons">
                            <img src="https://img.icons8.com/color/48/000000/visa.png" />
                            <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" />
                            <img src="https://img.icons8.com/color/48/000000/maestro.png" />
                        </div>
                    </div>
                        <span>Nombre titular:</span>
                        <input placeholder="Linda Williams">
                        <span>Numeros de la tarjeta:</span>
                        <input type="number" maxlength="16" placeholder="0125-6780-4567-9909">
                        <div class="row">
                            <div class="col-4"><span>Vecha vence:</span>
                                <input placeholder="YY/MM">
                            </div>
                            <div class="col-4"><span>CVV:</span>
                                <input id="cvv">
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="right border">
                    <div class="header">Items a comprar</div>
                    <div class="row item">
                        <div class="col-4 align-self-center"><img class="img-fluid" src="https://i.imgur.com/79M6pU0.png"></div>
                        <div class="col-8">
                            <div class="row"><b>$ 26.99</b></div>
                            <div class="row text-muted">Be Legandary Lipstick-Nude rose</div>
                            <div class="row">Qty:1</div>
                        </div>
                    </div>
                    <div class="row item">
                        <div class="col-4 align-self-center"><img class="img-fluid" src="https://i.imgur.com/Ew8NzKr.jpg"></div>
                        <div class="col-8">
                            <div class="row"><b>$ 19.99</b></div>
                            <div class="row text-muted">Be Legandary Lipstick-Sheer Navy Cream</div>
                            <div class="row">Qty:1</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row lower">
                        <div class="col text-left">Subtotal</div>
                        <div class="col text-right">$ 46.98</div>
                    </div>
                    <div class="row lower">
                        <div class="col text-left">Delivery</div>
                        <div class="col text-right">Free</div>
                    </div>
                    <div class="row lower">
                        <div class="col text-left"><b>Total to pay</b></div>
                        <div class="col text-right"><b>$ 46.98</b></div>
                    </div>
                    
                    <button class="btn pagar">Pagar</button>
                    <p class="text-muted text-center">Politica de reembolsos y devoluciones</p>
                </div>
            </div>
            <input type="hidden" name="idCompra" value="<?= $idCompra ?>">
            </form>
        </div>
    </div>
    <div>
    </div>
</div>
<link rel="stylesheet" href="css/pago.css">
<script src="js/actualizarCompraEstadoTipo.js"></script>
<?php
include_once("../menu/pie.php") //holahhj
?>
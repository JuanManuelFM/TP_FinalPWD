<?php
include_once("../../configuracion.php");
include_once("../menu/cabecera.php");
?>
<div class="card">
    <div class="card-top border-bottom text-center">
        <a href="../PaginaSegura/Inicio.php"> Volver al inicio</a>
    </div>
    <div class="card-body">
        <br>
        <div class="row">
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
                    <form>
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
                    </form>
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
                    <button class="btn">Pagar</button>
                    <p class="text-muted text-center">Politica de reembolsos y devoluciones</p>
                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
</div>
<link rel="stylesheet" href="css/pago.css">
<?php
include_once("../menu/pie.php") //holahhj
?>
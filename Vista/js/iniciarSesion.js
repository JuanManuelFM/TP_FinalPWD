function redireccionarPaginaInicio() {
    location.href = '../paginaSegura/inicio.php'
}
function redireccionarInicioSesion() {
    location.href = 'login.php'
}

function comprobarCuenta(){
    let usuarioIngresado = localStorage.getItem('usuarioIngresado')
    let contraseñaIngresada = localStorage.getItem('contrasenaIngresada')
    if (localStorage.getItem('contrasena') != null && localStorage.getItem('nombre') != null){
        if(localStorage.getItem('nombre') == usuarioIngresado && localStorage.getItem('contrasenia') == contraseñaIngresada){
            localStorage.setItem('inicio', 'si');
            Swal.fire({
                icon: 'success',
                title: 'Se ha iniciado sesion correctamente!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout("redireccionarPaginaInicio()", 1450);
        }else{
            localStorage.setItem('inicio', 'no');
            Swal.fire({
                icon: 'error',
                title: 'La contraseña y/o el usuario no existen!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout("redireccionarInicioSesion()", 1450);
        }
    }else{
        localStorage.setItem('inicio', 'no');
        Swal.fire({
            icon: 'error',
            title: 'No existe la cuenta ingresada!',
            showConfirmButton: false,
            timer: 1500
        })
        setTimeout("redireccionarInicioSesion()", 1450);
    }
}
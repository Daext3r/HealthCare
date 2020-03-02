$(document).ready(function () {
    $("#cambiarClave").on("click", function () {
        //mostramos un pop-up
        Swal.fire({
            icon: 'info',
            title: 'Cambiar clave',
            text: 'No podrás deshacer esta opción',
            input: 'password',
            inputPlaceholder: 'Introduce tu contraseña',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        }).then(password => {
            //cuando se introduzca una contraseña
            $("#clave").val(password.value);
        })
    });

});
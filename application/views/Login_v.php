<body>
    <div class="row shadow-lg p-3 mb-5 bg-white rounded">
        <img src="<?php echo base_url()?>assets/img/logo.png" alt="" srcset="">
        <form method="POST" action="<?php echo base_url() ?>login/autenticar">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="clave">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave">
                <small class="form-text text-muted">Déjalo en blanco si no tienes contraseña</small>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
            </div>
            <button id="qr" class="btn btn-outline-primary">Escanear QR</button>
            <button type="submit" class="btn btn-success">Iniciar sesión</button>
        </form>
    </div>


    <script>
        //evento de documento cargado
        $(document).ready(() => {
            //evitamos que al pulsar el boton de escanear qr envie el formulario
            $("#qr").on("click", function () {
                
            })
        });
    </script>
</body>
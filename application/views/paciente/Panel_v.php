<body>
    <!--seccion del menu lateral-->
    <section id="menu">

    </section>

    <!--seccion del contenido-->
    <div id="pagina">
        <nav id="header">
            <div class="headerItem"><?php echo $this->session->userdata("nombre") . " " . $this->session->userdata("apellidos") ?></div>
            <div class="headerItem" id="reloj"></div>
            <div class="headerItem hover" id="notificaciones">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones pendientes</div>
            <div id="logout"><i class="fas fa-sign-out-alt"></i>
                <p>Salir</p>
            </div>
        </nav>

        <section id="contenido">
            c
        </section>
    </div>

    <script src="<?php echo base_url() ?>assets/scripts/paciente.js"></script>
    <script>
        $("#logout").on("click", () => {
            //si hace clic en el boton de logout, redirigimos al login
            window.location = "<?php echo base_url()?>" + "paciente/logout";
        });
    </script>
</body>
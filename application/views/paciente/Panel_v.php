<body>
    <!--seccion del menu lateral-->
    <section id="menu">
        <div id="perfil">
            <div id="imgperfil">
                <img src="https://www.jennstrends.com/wp-content/uploads/2013/10/bad-profile-pic-2-768x768.jpeg" alt="">
            </div>

            <div id="nombre">
                <?php echo $this->session->userdata("nombre") . " " . $this->session->userdata("apellidos") ?>
            </div>

            <div class="separador"></div>
        </div>
        
        <div id="secciones">

        </div>
    </section>

    <!--seccion del contenido-->
    <div id="pagina">
        <nav id="header">
            <div class="headerItem"></div>
            <div class="headerItem" id="reloj"></div>
            <div class="headerItem hover" id="notificaciones">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones pendientes</div>
            <div id="logout"><i class="fas fa-sign-out-alt"></i>
                <p>Salir</p>
            </div>
        </nav>

        <section id="contenido">

        </section>
    </div>

    <script src="<?php echo base_url() ?>assets/scripts/paciente.js"></script>
    <script>
        $("#logout").on("click", () => {
            //si hace clic en el boton de logout, redirigimos al login
            window.location = "<?php echo base_url() ?>" + "paciente/logout";
        });
    </script>
</body>
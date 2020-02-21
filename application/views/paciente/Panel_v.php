<body>
    <!--seccion del menu lateral-->
    <section id="menu">

    </section>

    <!--seccion del contenido-->
    <div id="pagina">
        <nav id="header">
            <div class="headerItem"><?php echo $this->session->userdata("nombre") . " " . $this->session->userdata("apellidos")?></div>
            <div class="headerItem" id="reloj"></div>
            <div class="headerItem">Tienes 0 notificaciones pendientes</div>
        </nav>

        <section id="contenido">
            c
        </section>
    </div>

    <script src="<?php echo base_url() ?>assets/scripts/paciente.js"></script>
</body>
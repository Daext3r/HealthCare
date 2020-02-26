<body>
    <!--Scripts necesarios para el reloj y navegacion-->
    <script src="<?php echo base_url() ?>assets/scripts/paciente.js"></script>
    <script>
        $("#logout").on("click", () => {
            //si hace clic en el boton de logout, redirigimos al login
            window.location = "<?php echo base_url() ?>" + "paciente/logout";
        });

        //cuando se cargue el documento
        $(document).ready(function() {

            //para cada elemento del menu
            for (let a of document.getElementsByClassName("list-group")[0].children) {
                
                //si el href coincide con la url actual
                if (a.href == window.location.href) {

                    //añade la clase active para que resalte en azul
                    a.children[0].classList.add("active");
                }
            }
        });
    </script>

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
            <ul class="list-group">
                <a href="<?php echo base_url() ?>paciente/inicio">
                    <li class="list-group-item seccion">Inicio</li>
                </a>
                <a href="<?php echo base_url() ?>paciente/citas">
                    <li class="list-group-item">Citas</li>
                </a>
                <a href="<?php echo base_url() ?>paciente/tratamientos">
                    <li class="list-group-item">Tratamientos</li>
                </a>
                <a href="<?php echo base_url() ?>paciente/informes">
                    <li class="list-group-item">Informes</li>
                </a>
                <a href="<?php echo base_url() ?>paciente/misdatos">
                    <li class="list-group-item">Mis Datos</li>
                </a>

            </ul>
        </div>
    </section>

    <!--seccion del contenido-->
    <div id="pagina">
        <nav id="header">
            <div class="headerItem" id="reloj"></div>
            <div class="separador-v"></div>
            <div class="headerItem hover" id="notificaciones">Tienes <span id="notificaciones" class="badge badge-pill badge-danger">0</span> notificaciones pendientes</div>
            <div class="separador-v"></div>
            <div id="logout"><i class="fas fa-sign-out-alt"></i>
                <p>Salir</p>
            </div>
        </nav>
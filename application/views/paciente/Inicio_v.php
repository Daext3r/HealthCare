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
</body>a
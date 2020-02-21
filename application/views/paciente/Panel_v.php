<body>
    <!--seccion del menu lateral-->
    <section id="menu">

    </section>

    <!--seccion del contenido-->
    <div id="pagina">
        <nav id="header">
            <div class="headerItem"><?php echo $this->session->userdata("nombre") . " " . $this->session->userdata("apellidos")?></div>
            <div class="headerItem" id="reloj"></div>
            <div class="headerItem"></div>
        </nav>

        <section id="contenido">
            c
        </section>
    </div>

    <script>
    $(document).ready(function(){
        
        let dias = new Array("lunes", "martes", "miércoles", "jueves", "viernes", "sabado", "domingo");
        let meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        function actualizarFecha() {
        let d = new Date();
            let cadena = "Hoy es ";
            cadena += dias[d.getUTCDay() - 1] + " ";
            cadena += d.getUTCDate() + " de ";
            
            cadena += meses[d.getUTCMonth()] + " de ";
            cadena += d.getUTCFullYear();

            cadena += " | ";

            cadena += d.getHours() + ":";
            cadena += d.getMinutes();
            $("#reloj").text(cadena);
    }
        //ejecutamos la funcion de la fecha una vez
        actualizarFecha();      

        //intervalo de ejecucion del reloj
        setInterval(actualizarFecha, 10000);
    });

    
    </script>
</body>
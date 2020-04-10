$(document).ready(() => {
   $("#botonera").pagination({
      dataSource: (done) => {
         $.post(localStorage.getItem("hc_base_url") + "Centros_controller/leerAdministrativosCentro", {}, (data) => {
            data = JSON.parse(data);
            done(data);
         });
      },
      callback: function (data, pagination) {
         $("#paginas").html("");
         for (let usuario of data) {
            let parent = document.createElement("div");
            parent.classList.add("alert-secondary");
            parent.classList.add("usuario");

            let info = document.createElement("div");
            info.classList.add("info");
            parent.appendChild(info);

            let nombre = document.createElement("div");
            nombre.innerHTML = usuario.nombre_completo;
            info.appendChild(nombre);

            let ciu = document.createElement("small");
            ciu.innerHTML = usuario.CIU_administrativo;
            info.appendChild(ciu);

            let btn = document.createElement("button");
            btn.classList.add("btn");
            btn.classList.add("btn-danger");
            btn.innerHTML = "&times;";
            parent.appendChild(btn);

            $("#paginas").append($(parent));

            btn.addEventListener("click", () => {
               Swal.fire({
                  icon: 'question',
                  title: 'Confirmación',
                  text: `¿Deseas revocar a ${usuario.nombre_completo} los permisos de administrativo del centro?`,
                  showCancelButton: true,
                  confirmButtonText: 'Si',
                  confirmButtonColor: '#28a745',
                  cancelButtonColor: '#d33',
                  cancelButtonText: 'No, cancelar'
               }).then((e) => {
                  if(e.value) {
                     $.post(localStorage.getItem("hc_base_url") + "Centros_controller/eliminarAdministrativo", {ciu: usuario.CIU_administrativo}, (data) => {
                        if(data == 1) {
                           Swal.fire({
                              icon: 'success',
                              title: 'Hecho',
                              text: 'Se ha eliminado al usuario como administrativo '
                           }).then(()=> {window.location.reload()});
                        }
                     });
                  }
               })
            });
         }
      },
      pageSize: 5,
      showPageNumbers: false,
      showNavigator: true,
      formatNavigator: "Página <%= currentPage %> de <%= totalPage %>"
   });   

   //contiene un timeout para no saturar al servidor con peticiones a la hora de buscar un gerente
   var interval;
   $("#usuario").keyup(function () {
      //borramos la busqueda anterior
      clearTimeout(interval);

      //borramos lo que haya en la lista
      $("#usuarios").html("");

      //si el input esta vacio, no busca nada
      if ($("#usuario").val().trim() == "") return;

      interval = setTimeout(function () {
         $.post(localStorage.getItem("hc_base_url") + "Usuarios_controller/buscarUsuarioCiu", { ciu: $("#usuario").val() }, (data) => {
            data = JSON.parse(data);
            for (let usuario of data) {
               let option = document.createElement("option");
               option.value = usuario.CIU;
               option.innerText = usuario.nombre_completo;
               $("#usuarios").append($(option));
            }
         });
      }, 700);
   });

   //si cambia es que ha seleccionado un usuario
   $("#usuario").change(function () {
      //nombre del usuario
      let nombre;

      //buscamos el nombre del que hemos seleccionado
      for (let hijo of $("#usuarios").children()) {
         if ($(hijo).val() == $(this).val()) {
            nombre = $(hijo).html();
         }
      }

      Swal.fire({
         title: '¿Estás seguro?',
         text: `¿Quieres añadir a ${nombre} como administrativo de tu centro?`,
         icon: 'question',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         cancelButtonText: 'No, cancelar',
         confirmButtonText: 'Si, añadirlo.'
      }).then((result) => {
         if (result.value) {
            $.post(localStorage.getItem("hc_base_url") + "Centros_controller/agregarAdministrativo", { usuario: $(this).val() }, (data) => {
               if (data == 1) {
                  Swal.fire(
                     'Hecho',
                     `Se ha añadido a ${nombre} como administrativo`,
                     'success'
                  ).then(() => { window.location.reload() });
               }
            }).catch((e) => {
               if (e.responseText.includes("Duplicate entry")) {
                  Swal.fire(
                     'Error',
                     `${nombre} ya es administrativo de algun centro`,
                     'error'
                  )
               }
            })
         }
      })
   })
});
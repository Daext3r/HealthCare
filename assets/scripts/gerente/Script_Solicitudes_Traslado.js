$(document).ready(() => {
   $.post(localStorage.getItem("hc_base_url") + "Gerente_controller/leerTraslados", {} ,(data) => {
      data = JSON.parse(data);

      if(data.length == 0) {
         $(".contenido").append($("<h3>No tienes traslados pendientes de confirmar</h3>"));
         return;
      }
      
      for(let traslado of data) {
         let alert = $(`
         <div class="alert alert-secondary w-75 row">
            <div class="col col-10">El gerente del centro <b>'${traslado.nombre_centro_destino}'</b>, <b>${traslado.nombre_gerente_destino}</b>, ha solicitado el traslado del facultativo <b>${traslado.nombre_facultativo}</b> con CIU <b>${traslado.CIU_facultativo}</b> a su centro.</div>
            <div class="col col-1"><button class="btn btn-success" onclick="resolverTraslado(${traslado.id}, true)"><i class="fas fa-check"></i></button></div>
            <div class="col col-1"><button class="btn btn-danger" onclick="resolverTraslado(${traslado.id}, false)"><i class="fas fa-times"></i></button></div>
         </div>
         `);

         $(".contenido").append($(alert));
      }
   })
});

function resolverTraslado(id, res){
   $.post(localStorage.getItem("hc_base_url") + "Gerente_controller/resolverTraslado", {id: id, res: res}, (data) => {
         console.log(data);
      if(data == 1) {
         Swal.fire({
            icon: 'success',
            title: 'Hecho',
            text: `Se ha ${res == true? "confirmado" : "cancelado"} el traslado correctamente`
         }).then((e) => window.location.reload());
      }
   })
}
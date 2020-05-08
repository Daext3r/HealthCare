<?php
defined('BASEPATH') or exit('No direct script access allowed');

//A esta clase solo está permitido el acceso por ajax.

class Informes extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      $this->load->model("Informes_model");
   }

   public function leerListaInformes()
   {
      //si propio es true, significa que es el propio paciente el que quiere ver los informes
      //de lo contrario será un facultativo, por lo que se tendrá que especificar el ciu en la peticion ajax
      if ($this->input->post("propio") == "true") {
         echo json_encode($this->Informes_model->leerListaInformes($this->session->userdata("ciu")));     
      } else {
         echo json_encode($this->Informes_model->leerListaInformes($this->input->post("ciu")));
      }
   }

   public function guardarInforme()
   {
      if (!$this->input->is_ajax_request()) {
         redirect(base_url());
         return;
      }

      $contenido = $this->input->post("contenido");
      $fac = $this->session->userdata("ciu");
      $paciente = $this->input->post("paciente");
      $episodio = $this->input->post("episodio");

      $fecha = new DateTime();


      echo $this->Informes_model->guardarInforme($contenido, $fac, $paciente, $episodio, $fecha->format("Y-m-d"), $fecha->format("H:i:s"));
   }

   public function ver($id = null)
   {

      //si no se introduce una id valida mostramos error
      if (!is_numeric($id)) {
         $this->load->view("modules/ViewModule_Head", array(
            "hojas" => array("modules/StyleModule_Error")
         ));

         $this->load->view("modules/ViewModule_Error", array("mensaje" => "Parece que has introducido un número de informe no valido... Puedes cerrar esta pestaña."));
         return;
      }

      //leemos el informe
      $informe = $this->Informes_model->leerInforme($id);
      $informe['contenido'] = str_replace("\n", "<br>", $informe['contenido']);
      $contenido = explode("===NEW_PAGE===", $informe['contenido']);

      $ciu_fac = $informe['CIU_medico'];
      $ciu_pac = $informe['CIU_paciente'];
      $fecha = $informe['fecha'];
      $hora = $informe['hora'];
      $nombre_fac = $informe['nombre_completo_medico'];
      $nombre_pac = $informe['nombre_completo_paciente'];
      $especialidad = $informe['especialidad'];
      $episodio = $informe['episodio'];

      //TODO: mostrar icono
      $privado = $informe['privado'] == 0 ? "<button class='btn btn-secondary'><i class='fas fa-unlock'></i></button>" : "<button class='btn btn-secondary'><i class='fas fa-lock'></i></button>";


      //miramos si no somos facultativos
      if ($this->session->userdata("tipo") != "facultativo") {
         //si somos el paciente del informe miramos si el informe es privado
         if ($this->session->userdata("ciu") == $ciu_pac) {
            //si el informe es privado mostramos error
            if ($informe['privado'] == 1) {
               $this->load->view("modules/ViewModule_Head", array(
                  "hojas" => array("modules/StyleModule_Error")
               ));

               $this->load->view("modules/ViewModule_Error", array("mensaje" => "Este informe es privado y solo lo puede ver un facultativo. Acude a tu médico de referencia."));
               return;
            }
         } else {
            //si el usuario no es facultativo y no es el propio paciente
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Error")
            ));

            $this->load->view("modules/ViewModule_Error", array("mensaje" => "No tienes permiso para acceder a este informe."));
            return;
         }
      }

      //si hemos llegado hasta aqui es que tenemos permiso para ver el informe, y lo generamos
      require APPPATH . "vendor/autoload.php";

      $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $mpdf = new \Mpdf\Mpdf([
         'fontDir' => array_merge($fontDirs, [
            __DIR__ . './assets/fonts',
         ]),
         'fontdata' => $fontData + [
            'Rubik' => [
               'R' => 'Rubik-Regular.ttf',
            ]
         ],
         'default_font' => 'Rubik',
         'autoMarginPadding' => 0,
         'dpi' => 100
      ]);



      for ($pagina = 0; $pagina < count($contenido); $pagina++) {
         $mpdf->WriteHTML(
            <<<EOT
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <title>$id</title>
               <style>
                  
                  @page {
                     margin: 40px;
                  }
            
                  #page {
                     position: relative;
                     width: 100%;
                     height: 100%;
            
                     display: flex;
                     justify-content: center;
                     align-items: center;
                     flex-wrap: wrap;
                     padding-top: 1px;
                  }
            
                  .header {
                     height: 117px;
                     width: 785px;
                     position: absolute;
                     display: block;
                     
                  }
            
                  table {
                     border-collapse: collapse;
                   }
                   
                   table, th, td {
                     border: 1px solid grey;
                   }
                   td {
                      padding: 6px;
                   }
                  .contenido {
                     height: 810px;
                     width: 765px;
                     border: 1px solid grey;
                     border-radius: 3px;
                     margin-top: 25px;
                     padding: 10px;
                  }
            
                  .contenido-title {
                     position: absolute;
                     margin-left: 25px;
                     top: 142px;
                     font-size: 17px;
                  }
            
                  .footer {
                     height: 15px;
                     width: 775px;
                     border: 1px solid grey;
                     position: relative;
                     padding: 5px;
                     border-radius: 3px;
                     margin-top: 20px;
                  }
                  
                  .vc {
                     top: 50%;
                     transform: translateY(-50%);
                  }
            
                  img.logo {
                     position: absolute;
                     margin: 0.5em;
                     margin-left: 10px;
                     top: 5px;
                     width: 50px;
                  }
            
                  .nombres {
                     position: absolute;
                     margin-left: 90px;
                  }
            
                  .episodio {
                     position: absolute;
                     top: 87px;
                     margin-left: 100px;
                  }
            
                  .fechahora {
                     position: absolute;
                     top: 87px;
                     margin-left: 300px;
                  }
            
                  .facultativo, .paciente {
                     margin: 10px;
                  }
            
                  .barcode {
                     height: 40px;
                  }
                  .center {
                     text-align: center;
                  }
                  .ciu {
                     width: 20%;
                  }
               </style>
            </head>
            
            <body>
               <div id="page">
                  <table class="header" border="1">
                     <tr>
                        <td class="center" style="width: 13%">
                           <img src="./assets/img/icon-big-bw.png" alt="" class="logo">
                        </td>
                        <td class="center" colspan="2">
                           <div class="title">Informe de $especialidad</div>
                        </td>
                        <td rowspan="2" colspan="2" class="center"><div class="barcode"><barcode code="$id" type="C39" class="barcode"/></div></td>
                     </tr>
                     <tr>
                        <td class="center">Facultativo:</td>
                        <td>$nombre_fac</td>
                        <td class="ciu">$ciu_fac</td>
                     </tr>
                     <tr>
                        <td class="center">Paciente:</td>
                        <td>$nombre_pac</td>
                        <td class="ciu">$ciu_pac</td>
                        <td class="center" colspan="2">$id</td>
                     </tr>
                     <tr>
                        <td class="center">Episodio:</td>
                        <td>$episodio</td>
                        <td class="center">Fecha y hora:</td>
                        <td>$fecha | $hora</td>
                        <td>$privado</td>
                     </tr>
                  </table>
                  <div class="contenido">
                     $contenido[$pagina] 
                  </div>
                  <div class="footer">
                     <span class="hint vc">Si tiene alguna duda sobre este informe consulte a su médico de referencia</span>
                  </div>
               </div>
            </body>
            </html>
            EOT
         );

         //si queda mas contenido añadimos otra pagina
         if ($pagina != count($contenido) - 1) $mpdf->AddPage();
      }

      //mostramos el pdf
      $mpdf->Output();
   }
}

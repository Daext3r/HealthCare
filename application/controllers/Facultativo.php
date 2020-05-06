<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facultativo extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();

      //si no es el tipo de perfil que corresponde a este panel, redirigimos al login
      if ($this->session->userdata("tipo") != "facultativo") {
         //redirigimos al login
         redirect(base_url() . "login");
         return;
      }
   }

   public function inicio()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive"),
         "scripts" => array("modules/ScriptModule_Panel")
      ));
      $this->load->view("modules/ViewModule_Panel");
   }

   public function citas()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Citas"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Citas")
      ));

      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("facultativo/View_Citas");
   }

   public function informes($accion)
   {
      switch ($accion) {
         case 'nuevo':
            $this->load->view("modules/ViewModule_Head", array(
               "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_NuevoInforme", "facultativo/Style_ListaPacientes"),
               "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_NuevoInforme", "facultativo/Script_ListaPacientes")
            ));

            $this->load->view("modules/ViewModule_Panel");

            $this->load->view("facultativo/View_NuevoInforme");
            break;

         case 'historial':
            break;
      }
   }

   public function episodios()
   {
      $this->load->view("modules/ViewModule_Head", array(
         "hojas" => array("modules/StyleModule_Panel", "modules/StyleModule_Panel_Responsive", "facultativo/Style_Episodios", "facultativo/Style_ListaPacientes"),
         "scripts" => array("modules/ScriptModule_Panel", "facultativo/Script_Episodios", "facultativo/Script_ListaPacientes")
      ));

      $this->load->view("modules/ViewModule_Panel");

      $this->load->view("facultativo/View_Episodios");
   }

   public function verinforme($id = null)
   {
      require APPPATH . "vendor/autoload.php";

      $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
      $img = $generator->getBarcode('231231234234234234242423424234234231233', $generator::TYPE_CODE_128, 1, 40);
     
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


      $this->load->model("Informes_model");

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

      for($pagina = 0; $pagina < count($contenido); $pagina++) {
      $mpdf->WriteHTML(
         <<<EOT
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <title>Document</title>
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
                        <td rowspan="2" class="center"><div class="barcode"><barcode code="$id" type="C39" class="barcode"/></div></td>
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
                        <td class="center">$id</td>
                     </tr>
                     <tr>
                        <td class="center">Episodio:</td>
                        <td>$episodio</td>
                        <td class="center">Fecha y hora:</td>
                        <td>$fecha | $hora</td>
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
      
      if($pagina != count($contenido) - 1) $mpdf->AddPage();
   }

      $mpdf->Output();
   }
}

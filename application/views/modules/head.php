<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare</title>
    <!--Libreria de Font Awesome-->
    <script src="https://kit.fontawesome.com/fabf6e77eb.js" crossorigin="anonymous"></script>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
    <link rel="icon" href="<?php echo base_url()?>assets/img/icon.png">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Rubik&display=swap');
        * {
            font-family: 'Rubik';
        }
    </style>
<!--carga hojas de estilos de forma dinamica-->
        <?php
            //si hay hojas...
            if(isset($hojas)) {
                //carga cada hoja
                foreach($hojas as $hoja) {
                    $link = '<link rel="stylesheet" href="'.base_url().'assets/styles/' .$hoja. '.css">';
                    echo $link;
                }
            }
        ?>
</head>
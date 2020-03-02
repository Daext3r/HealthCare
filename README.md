# HealthCare

## ¿Qué es HealthCare?
HealthCare es una aplicación pensada para llevar la administración de un centro de salud. A la plataforma podrán acceder los médicos y los pacientes para realizar distintas tareas tales como pedir citas (pacientes) o realizar informes (médicos) entre muchas otras acciones

## ¿Cuál es el objetivo del proyecto?

### General
El objetivo de esta aplicación es hacer más fácil las diferentes opciones que se pueden realizar en un centro de salud.

Los pacientes podrán realizar accioens como administrar sus citas con los médicos (solicitar, modificar o cancelar), consultar tratamientos activos, ver el hiotorial de análisis o consultar los informes realizados.

Los médicos podrán atender las citas ,administrar tratamientos de los pacientes, ordenar análisis, o solicitar citas con los especialistas, entre otros.

### Funcionalidades

1. Crear perfiles de pacientes por parte del personal administrativo.
2. Crear perfiles de facultativos por parte del personal administrativo. 
3. Añadir o revocar permisos a un usuario
4. Verificar la identidad de las personas que tratan de acceder a la aplicación y ofrecer la opción de seleccionar un perfil en caso de tener acceso a más de uno.
5. Crear un sistema de gestión de citas.
6. Crear un sistema de gestión de informes.

## Instalación

1. Instala un servidor Web con Apache y MySQL. Si no lo tienes, debes instalar Git.
2. Importa el archivo .sql en el SGBD.
3. Realiza una instalación de CodeIgniter.
4. Ejecuta los siguientes comandos **en la carpeta raíz de CodeIgniter**.
    * `git init`
    * `git remote add origin https://github.com/Daext3r/HealthCare`
    * `git fetch origin`
    * `git checkout -b master --track origin/master -f`
5. Si has realizado todos los pasos correctamente ya deberías tener instalado HealthCare en tu equipo

* Nota: Si lo deseas, puedes borrar el controlador y la vista por defecto de CodeIgniter, WelcomeMessage.


# Licencias | Licenses
All code here was made from scratch by Alejandro D. (Daext3r) excetp the following things in the list:
1. [CodeIgniter](https://codeigniter.com)
2. [Bootstrap](https://getbootstrap.com)
3. [jQuery](https://jquery.com)
4. [Twemoji](https://github.com/twitter/twemoji)
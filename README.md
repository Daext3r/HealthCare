# HealthCare

## ¿Qué es HealthCare?
HealthCare es una aplicación pensada para llevar la administración de un centro de salud. A la plataforma podrán acceder los médicos y los pacientes para realizar distintas tareas tales como pedir citas (pacientes) o realizar informes (médicos) entre muchas otras acciones

## ¿Cuál es el objetivo del proyecto?

### General y descripción
La aplicación está pensada desde un alto punto de vista, es decir, está pensada para ser intalada en un servidor que debe ser administrado por una entidad superior como puede ser el Servicio Extremeño de Salud o el Sistema Nacional de Salud. Esto es así por la cantidad de funciones que tiene.

Las funciones serán enumeradas según los perfiles:
1. Admin: 
    Este usuario es el administrador del sitio. Solo puede crear nuevos centros, y crear nuevos usuarios. Se recomienda que los usuarios que cree solo sea para darle los permisos de gerente (punto 2). Además de esto, también será el encargado de crear nuevas especialidades que serán usadas por los administrativos para asignarlas a un facultativo.

2. Gerente: 
    Los gerentes son los directores de los centros, ya sea un hospital, residencia, o centro de salud. No hay diferencia. Los gerentes podrán cambiar la configuración del centro y crear nuevos usuarios. Se recomienda que los usuarios creados sean solo administrativos (punto 3).

3. Administrativo: 
    Los administrativos podrán realizar distintas tareas en el centro, tales como crear perfiles de paciente, de facultativo, cambiar datos de un perfil, cambiar permisos, pedir cita en nombre de un paciente... A pesar de todas estas acciones, no podrán ver informes o tratamientos de los pacientes.

4. Facultativo: 
    Se entiende por facultativo a cualquier profesional médico de cualquier especialidad que no sea un enfermero. Medicina general, traumatología u oftalmología son algunas de las especialidades, por ejemplo. Los facultativos podrán derivar (solicitar cita) un paciente a otro facultativo que sea especialista. Además, al derivar se permite el añadir una descripción o motivo de cita.

5. Enfermero: 
    El perfil de enfermero tiene permisos mucho más limitados que un facultativo. Aún por determinar. 

6. Paciente: 
    Los pacientes es parte del usuario base de la aplicación. Cuando se registra un usuario, por defecto se crea un perfil de paciente. El paciente en su mayoría puede consultar datos. Tratamientos, informes, resultados de analíticas o citas pendientes. Además, puede solicitar nuevas citas y editar datos de su perfil tales como el correo electrónico, teléfono o dirección.

7. Personal de laboratorio: 
    El personal de laboratorio será el encargado de cumplimentar las analíticas. Por el momento no tiene más funciones.

    * Nota: Está pendiente añadir más funcionalidades al paciente y al personal de laboratorio.
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
5. Entra en la carpeta `application` y ejecuta el siguiente comando: `composer install`. Necesitas tener instalado [Composer](https://getcomposer.org).
6. Si has realizado todos los pasos correctamente ya deberías tener instalado HealthCare en tu equipo.
* Nota: Si lo deseas, puedes borrar el controlador y la vista por defecto de CodeIgniter, WelcomeMessage.

## Configuración
- Antes de acceder a la página, es necesaria una configuración previa. Sin esta configuración, la aplicación no funcionará correctamente

1. En el archivo `/application/config/config.php`, debes ajustar el valor de `config['base_url']`. Por defecto está puesto el nombre del servidor y debería funcionar, pero puede ser necesario que lo cambies.
2. En el archivo `/assets/js/login.js` debes editar la linea en la que pone `localStorage.setItem("hc_base_url", "http://localhost/HealthCare/");` y el nombre del servidor si está en la red. Si estás trabajando en local para probar la aplicación, déjalo como está. 


# Licencias
Todo el código ha sido hecho desde cero por Alejandro D. (Daext3r) excepto los siguientes elementos en la lista:

1. [CodeIgniter](https://codeigniter.com)
2. [Bootstrap](https://getbootstrap.com)
3. [jQuery](https://jquery.com)
4. [Twemoji](https://github.com/twitter/twemoji)
5. [SweetAlert](https://sweetalert2.github.io)
6. [mPDF](https://mpdf.github.io)
7. [JWT](https://github.com/firebase/php-jwt/)
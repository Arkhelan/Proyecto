# Pasos para la instalación 

Para realizar toda la instalacion correctamente debera de visitar las carpetas siguiendo los Readme en este orden:

1. Instalación_Apache
2. MySQL
3. Scripts
4. CronJobs

Habiendo realizado los pasos en este orden ya debera funcionar todo.

# Cambios importantes
Los cambios mas significantes son los siguientes:
<li> La tabla de archivos ha cambiado y se han agregado mas tablas
<li> La pagina web hay mas funcionalidades, como el inicio de sesión y la propiedad de los archivos.
<li> Hay pequeñas mejoras en el codigo para poder registrar los usb en la base de datos y para señalar de donde viene cada fichero
<li> Funcionalidades exclusivas para el usuario administrador.

# Cambios dia 21/02/2023
Los cambios realizados al servidor mas significantes son:
<li> Se han creado las paginas de administrador que permiten: crear grupos, assignar a los usuarios a grupos y assignar usbs a usuarios o grupos.
<li> La pagina de archivos dentro del servidor web, solo sera accesible si el usuario a iniciado sessión y solo enseñara los archivos a los cual el usuario tenga acceso
<li> Todas las paginas web que necesitaban hacer consultas a la base de datos, ya estan actualizadas por los cambios en la base de datos.

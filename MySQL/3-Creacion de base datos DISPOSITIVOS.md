# Creación de base de datos (MALWARE)
### Una vez hayamos acabado la instalación de MySQL, procederemos a crear las base de datos y de las tablas.
Previamente habremos creado un usuario adminitrador: almanDB
### Iniciamos el servicio de MySQL
    <pre><code> service mysql start </pre></code>
### Entramos dentro de mysql con el usuario administrador.
    <pre><code>mysql -u almanDB -p</pre></code>
  Contraseña: Alm@n123
### Crearemos la base de datos que vamos a utilizar, El nombre sera MALWARE.
    <pre><code>CREATE DATABASE MALWARE;</pre></code>
### Utilizamos el siguiente comando para ver si se ha creado:
    <pre><code>SHOW DATABASES;</pre></code>

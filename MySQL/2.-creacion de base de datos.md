# Creación de usuario y tablas
Una vez hayamos acabado la instalación de MySQL, procederemos a crear las tablas y del usuario que la administrara.
<br>Iniciamos el servicio de MySQL
<pre><code>service mysql start</code></pre>
Entramos dentro de mysql con el usuario administrador.
<pre><code>mysql -u root -p</code></pre> 
Cuando ejecutemos el comando anterior veremos que la consola cambiara a algo como esto:
<pre><code>mysql></code></pre>
Crearemos la base de datos que vamos a utilizaar, el nombre que va a llevar sera usbdb.
<pre><code>CREATE DATABASE usbdb;</code></pre>
Utilizamos el siguiente comando para ver si se ha creado:
<pre><code>SHOW DATABASES;</code></pre>
Crearemos un usuario el cual tenga permisos totales sobre la nueva base de datos, cambia el vacio por la contraseña que le quieras dar.
<pre><code>CREATE USER 'usu'@'localhost' IDENTIFIED BY '';</code></pre>
Le daremos todos los privilegios de la base de datos a usu:
<pre><code>GRANT ALL PRIVILEGES ON usbdb.* TO usu@localhost ;</code></pre>
Antes de salir de la consola MySQL realizamos un «Flush» de los privilegios:
<pre><code>FLUSH PRIVILEGES;</code></pre>
Antes de acabar comprobaremos que se pueda acceder desde el nuevo usuario.
<pre><code>mysql -u usu -p</code></pre>
Luego de ejecutar el comando anterior nos pedira la contraseña, cuando entremos ejecutaremos el comando:
<pre><code>use usbdb</code></pre>

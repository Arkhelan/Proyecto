### Tras la instalación de MySQL arancamos el srvicio:
<pre><code>service mysql start</code></pre>
### Entraremos en su consola de la siguiente manera:
<pre><code>mysql -u root -p</code></pre> 
#### Estaremos dentro de sistema , con el siguiente pront de consola:
<pre><code>mysql></code></pre>
### Crearemos la base de datos ‘PROYECT_DB‘ que luego  le asignaremos un usuario administrador, para no usar  root.
<pre><code>CREATE DATABASE usbdb;</code></pre>
### vemos que se ha creado :
<pre><code>SHOW DATABASES;</code></pre>
### Asignación de un usuario, con todos los privilegios.
#### creacion del usuario (pr_db) y la contraseña(1111):
<pre><code>CREATE USER 'usu'@'localhost' IDENTIFIED BY '1111';</code></pre>
#### Le otorgamos todos los privilegios sobre la base de datos:
<pre><code>GRANT ALL PRIVILEGES ON usbdb.* TO usu@localhost ;</code></pre>
### Antes de salir de la consola MySQL realizamos un «Flush» de los privilegios:
<pre><code>FLUSH PRIVILEGES;</code></pre>
### Para salir de la terminal de mysql usaremos ‘QUIT’ o ‘EXIT’
Si queremos acceder directamente a la base de datos:
<pre><code>mysql -u usu -p'1111' 'usbdb';</code></pre>
Tambien podemos hacerlo por pasos con los siguientes comandos:
<pre><code>mysql -u usu -p '1111'
use 'usbdb'</code></pre>

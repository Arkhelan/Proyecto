### Tras la instalación de MySQL arancamos el srvicio:
<pre><code>service mysql start</code></pre>
### Entraremos en su consola de la siguiente manera:
<pre><code>mysql -u root -p</code></pre> 
#### Estaremos dentro de sistema , con el siguiente pront de consola:
<pre><code>mysql></code></pre>
### Crearemos la base de datos ‘PROYECT_DB‘ que luego  le asignaremos un usuario administrador, para no usar  root.
<pre><code>CREATE DATABASE PROYECT_DB;</code></pre>
### vemos que se ha creado :
<pre><code>SHOW DATABASES;</code></pre>
### Asignación de un usuario, con todos los privilegios.
#### creacion del usuario (pr_db) y la contraseña(1111):
<pre><code>CREATE USER 'pr_db'@'localhost' IDENTIFIED BY '1111';</code></pre>
#### Le otorgamos todos los privilegios sobre la base de datos:
<pre><code>GRANT ALL PRIVILEGES ON PROYECT_DB.* TO pr_db@localhost ;</code></pre>
### Antes de salir de la consola MySQL realizamos un «Flush» de los privilegios:
<pre><code>FLUSH PRIVILEGES;</code></pre>
### Para salir usaremos ‘QUIT’ o ‘EXIT’
###Si queremos acceder directamente a la base de datos:

<pre><code>mysql -u pr_db -p'1111' 'PROYECT_DB';</code></pre>





<pre><code></code></pre>

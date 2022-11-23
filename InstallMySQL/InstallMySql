# Instalación de sistema de Gestión de base de datos.MySql
## Actualización del sistema :


<pre><code>sudo apt update && sudo apt upgrade</code></pre>

### Comando instalacion MySql 
<pre><code>sudo apt install mysql-server mysql-client --fix-broken --fix-missing</code></pre>

### Vemos la versión:
<pre><code> MySql mysql --version</code></pre>

### Protecion del servidor

Una vez completada la instalación, puede proteger el servidor MySQL ejecutando el siguiente comando:

<pre><code>sudo mysql_secure_installation</code></pre>

Pasará por un asistente de preguntas para asegurar el servidor MySQL. Siga las instrucciones en pantalla a continuación. Presione " y " para habilitar el complemento de validación de contraseña. Esto le permitirá establecer una política estricta de contraseñas para las cuentas

La contraseña configurada anteriormente para las cuentas raíz solo se usa para usuarios remotos. Para iniciar sesión desde el mismo sistema, escriba mysql en la terminal: Contraseña: Zxc%1234

### Acceso a MySql 
<pre><code>sudo mysql</code></pre>

Accedemos a Mysql y creamos la base de datos y un usuario admin
### Creación de una base de datos

Con el siguiente comando crearemos la base de datos llamada 'alodb':

 mysql><pre><code>CREATE DATABASE mydb;</code></pre>

### Creación de un usuario 

Luego, cramos un usuario llamado 'myuseralo' accesible solo desde 'localhost':

<pre><code>CREATE USER 'myuseralo'@'localhost' IDENTIFIED BY 'secure_password_';</code></pre>

Otorgar permisos de acceso a la  base de datos al usuario creado :

 <pre><code>GRANT ALL ON alodb.* to 'myuseralo'@'localhost';</code></pre>

Aplicar los cambios de permisos en tiempo de ejecución:

<pre><code>FLUSH PRIVILEGES;</code></pre>

### Administrar el servicio MySQL 
Para comprobar el estado del servidor de la base de datos:
<pre><code>sudo systemctl status mysql </code></pre>
Para iniciar el servidor MySQL:
<pre><code>sudo systemctl start mysql</code></pre>
Para detener el servidor MySQL:
<pre><code>sudo systemctl stop mysql </code></pre>

### Desinstalar (eliminar)MySql 
<pre><code>sudo apt purge mysql-server-* </code></pre>
<pre><code>rm -rf /etc/mysql</code></pre> 
<pre><code>rm -rf /var/lib/mysql </code></pre>
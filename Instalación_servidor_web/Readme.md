# Instalación del servidor web
Hemos utilizado Apache,como servidor web y a continuación dejo la guia de instalación 
## Instalar Apache2
Actualizamos la maquina ejecutando los siguientes comandos
<pre><code>sudo apt-get update
sudo apt-get upgrade</code></pre>
Empezamos la instalación de Apache, utilizando el siguiente comando.
<pre><code>sudo apt-get install apache2</code></pre>
## Ajustar firewall
Con la maquina actualizada y apache instalado,  configuramos el firewall para permitir el acceso externo a los puertos. Utilizamos los siguientes comandos:
Para ver las aplicaciones que necesitan el uso de puertos:
<pre><code>sudo ufw app list</code></pre>
Permite  el acceso a Apache
<pre><code>sudo ufw allow 'Apache'</code></pre>
Verificarmos que el cambio anterior se ha realizado con el siguiente comando
<pre><code>sudo ufw status</code></pre>
verificamos el status 
<pre><code>Status: active

To                         Action      From
--                         ------      ----
Apache                     ALLOW       Anywhere                  
Apache (v6)                ALLOW       Anywhere (v6)             
</code></pre>
Si nos da  `Status: inactive`, en  utilizaremos el comando `sudo ufw enable` y volveremos a introducir `sudo ufw status`
## Comprobación del funcionamiento de Apache
Utilizar el comando 
<pre><code>sudo systemctl status apache2</code></pre>
Esto nos mostrara si esta activo  o no.

<br>Si esta inactivo probaremos que la pagina web este funcionando.
Para ello miramos la IP.
Para ello  introduciremos el comando siguiente :
<pre><code>hostname -I</code></pre>
Si ponemos la IP el navegador ha de salir una pagina de Apache que nos indica que el funcionamiento es ok
## Comandos para la administración de Apache
<br>Comando para PARAR el servicio de apache.
<pre><code>sudo systemctl stop apache2</code></pre>
Comando para INICIAR el servicio de Apache del servidor.
<pre><code>sudo systemctl start apache2</code></pre>
Comando para REINICIAR el servicio.
<pre><code>sudo systemctl restart apache2</code></pre>
Comando ACTIVAR NUEVA CONFIGURACIÓN del servidor sin necesidad de parar el servicio.
<pre><code>sudo systemctl reload apache2</code></pre>
Comando para NO INICIO AUTOMATICO al arrancar el servidor.
<pre><code>sudo systemctl disable apache2</code></pre>
Comando INICIO AUTOMATICO al arrancar el servidor.
<pre><code>sudo systemctl enable apache2</code></pre>
## Ficheros importantes
Ver ficheros importantes dentro de Apache:
- `/var/www/html` 
Esta es la ruta donde se alojan los ficheros html

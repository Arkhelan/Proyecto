# Instalación del servidor web
El servidor web que hemos decidido utilizar para el proyecto es Apache, y a continuación dejo la guia de instalación de Apache.
## Instalar Apache2
Antes de iniciar la instalación deberemos actualiza la maquina por lo que ejecutaremos los siguientes comandos
<pre><code>sudo apt-get update
sudo apt-get upgrade</code></pre>
Una vez acabe de actualizarse la maquina empezaremos la instalación de Apache, utilizando el siguiente comando.
<pre><code>sudo apt-get install apache2</code></pre>
## Ajustar firewall
Por el momento tenemos la maquina actualizada y apache instalado, a continuación antes de empezar a probar Apache deberemos de configurar el firewall para permitir el acceso externo a los puertos. Utilizaremos los siguientes comandos:
Este nos servira para ver las aplicaciones que necesitan el uso de puertos:
<pre><code>sudo ufw app list</code></pre>
Este comando nos permitira que permita el acceso a Apache
<pre><code>sudo ufw allow 'Apache'</code></pre>
Utilizaremos este comando para verificar que el cambio anterior a funcionado
<pre><code>sudo ufw status</code></pre>
Este es el resultado del último comando:
<pre><code>Status: active

To                         Action      From
--                         ------      ----
Apache                     ALLOW       Anywhere                  
Apache (v6)                ALLOW       Anywhere (v6)             
</code></pre>
Existe la posibilidad que unavez hecho los comandos en vez de ver esta última pantalla veamos una que pone `Status: inactive`, en ese caso utilizaremos el comando `sudo ufw enable` y volveremos a probar el último comando.

## Comprobación del funcionamiento de Apache
Para comprobar que Apache este funcionando bien deberemos utilizar el comando 
<pre><code>sudo systemctl status apache2</code></pre>
Esto nos mostrara si esta activo o inactivo, si esta inactivo lo mas probable es que haya un fallo en un archivo de configuración o algo.
<br>Ahora probaremos que la pagina web este funcionando, para saber eso necesitamos la IP para conectarnos, para que nos la muestre utilizaremos el comando 
<pre><code>hostname -I</code></pre>
Si ponemos esta Ip en nuestro buscador deberia salir una pagina de Apache diciendo que todo esta funcionando.
## Comandos para la administración de Apache
Los siguientes comando son importantes a la hora de que tengamos de manejar nuestro servidor mientras este tenga de estar en funcionamiento.
<br>Comando utilzado para parar el servicio de apache, utilizado para cuando se esta modificando alguna de las paginas del servidor y se esta probando cosas
<pre><code>sudo systemctl stop apache2</code></pre>
Comando para volver a iniciar el servicio de Apache del servidor.
<pre><code>sudo systemctl start apache2</code></pre>
Comando para reiniciar el servicio, a parte de reiniciar, este también pondra en uso la configuración modificada del servidor.
<pre><code>sudo systemctl restart apache2</code></pre>
Comando utilizado para poner en uso la configuración modificada del servidor sin necesidad de parar el servicio.
<pre><code>sudo systemctl reload apache2</code></pre>
Este comando sirve para quitar de predeterminado que Apache se inicie automaticamente al iniciar el equipo.
<pre><code>sudo systemctl disable apache2</code></pre>
Comando utilizado para poner de predeterminado que Apache se inicie automaticamente cuando se inicie el servidor.
<pre><code>sudo systemctl enable apache2</code></pre>
## Ficheros importantes
Los ficheros importantes dentro de Apache que deberiamos tener en cuenta son
- `/var/www/html` este directorio es donde deberemos poner todos nuestro archivos html para poder publicarla en nuestro servidor

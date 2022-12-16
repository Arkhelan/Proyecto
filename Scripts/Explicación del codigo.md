# Scripts
## Antes de empezar
Antes de empezar a programar, instalaremos 2 dependencias que son necesarias para el funcionamiento de los scripts
<pre><code>sudo apt-get install curl
sudo apt-get install jq</code></pre>
## Organización de carpetas
Antes de empezar crearemos 3 carptas dentro del directorio `/home/user/`:
<li>
fin: En esta carpeta estaran todos los scripts que se iran ejecutando.</li>
<li>
scripts: Aunque el nombre de la carpeta engañe, en esta carpeta se guardaran todos los archivos de ayuda que necesita el script para funcionar</li>
<li>
analysis: Esta carpeta servira para que los archivos que haya dentro del usb que se introduzca en la maquina se copien antes de hacer el analisis.
</li><br> 
También existe una última carpeta dentro del directorio /var/www/html que se llama archivos que es donde se suviran los archivos para que sean visibles dentro del servidor web.

## Detección de un USB
Creamos en la carpeta `/home/user/scripts` el archivo `detusb.sh` este script tendra la función de revisar si conectamos algún USB al servidor, y si detecta algún USB, mirara el tipo de partición que tiene este uSB y lo montara con un comando o otro en la carpeta `/media/usb`.
<br>Empezaremos creando la carpeta `/media/usb` utilizando el comando
<pre><code>sudo mkdir /media/usb/</code></pre>
Creamos el script utilizando los siguientes comandos.
<pre><code>touch /home/user/fin/detusb.sh
sudo chmod 777 /home/user/fin/detusb.sh </code></pre>
Entramos en el archivo `/home/user/fin/detusb.sh` y introduciremos el siguiente codigo
<pre><code># !/bin/bash
echo "el script de deteecion se ha iniciado" >> /home/albert/fin/registro
for (( ; ; ));
do
    a=0
    sleep 1
    for i in $(ls /dev/sd*)
	    do
            if [ $i != "/dev/sda" ] && [ $i != "/dev/sda1" ] && [ $i != "/dev/sda2" ] && [ $i != "/dev/sda3" ];
                then
                    a=$(echo $i)
                fi
	    done
    if [ $a != "0" ];
    then
        b=${a:-1}
        if [ "$b" == "1" ];
        then
                a=$a"1"
        fi
        break
    fi
done
mount $a /media/usb
sudo chmod 777 /media/usb
sudo bash /home/albert/fin/scriptfinal.sh
echo "el script ha finalizado" >> /home/albert/fin/registro
sudo bash /home/albert/fin/scriptfinal.sh
</code></pre>

### Resumen del codigo
Este codigo al inicio crea un bucle que se ejecutara infinitamente hasta que se utilize un `break` dentro de este.
<br>Luego creamos una variable contador llamada `a` que se iniciara con el valor 0 al empezar el bucle.
<br>Dentro del primerbucle creamos un bucle que en cada vuelta guardara en la variable `i` uno de los resultados de utilizar el comando `ls /dev/sd*`, el bucle terminara cuando se hayan acabado los resultados del comando anterior.
<br>Dentro del bucle se comprobara de que el contenido de i no sea igual a las carpetas que estan habitualmente en el servidor sin un usb, en cuanto entre, se le dara a la variable a el valor de i en ese momento.
<br>Fuera del segundo bucle hay un condicional que entrara en el caso de que el valor de a haya cambiado, en el caso de que haya cambiado, se rompera el bucle infinito.
<br>Fuera de los bucles, se monta la nueva unidad en la carpeta `/media/usb`, le cambia los permisos y ejecuta el codigo scriptfinal.sh que es el codigo mas principal.

## Codigo scriptfinal
Este script es el mas largo de todos ya que es el codigo principal de todos.

Empezaremos creando el fichero del script en el directorio `/home/user/fin` utilizaremos los siguientes comandos:
<pre><code>touch /home/user/fin/scriptfinal.sh
sudo chmod 777 /home/user/fin/scriptfinal.sh
</code></pre>
Entramos al archivo creado e introduciremos el siguiente codigo "Este codigo esta tambien en lacarpeta /home/albert/fin en GitHub"
<pre><code></code></pre>
# Scripts
## Antes de empezar
Antes de empezar a programar, instalaremos 2 dependencias que son necesarias para el funcionamiento de los scripts
<pre><code>sudo apt-get install curl
sudo apt-get install jq</code></pre>
## Detección de un USB
Creamos en la carpeta `/home/user/scripts` el archivo `detusb.sh` este script tendra la función de revisar si conectamos algún USB al servidor, y si detecta algún USB, mirara el tipo de partición que tiene este uSB y lo montara con un comando o otro en la carpeta `/media/usb`.
<br>Empezaremos creando la carpeta `/media/usb` utilizando el comando
<pre><code>sudo mkdir /media/usb/</code></pre>
Creamos el script utilizando los siguientes comandos.
<pre><code>touch /home/user/scripts/detusb.sh
sudo chmod 777 /home/user/scripts/detusb.sh </code></pre>
Entramos en el archivo `/home/user/scripts/detusb.sh` y introduciremos el siguiente codigo
<pre><code># !/bin/bash
for (( ; ; ))
do
a=0
    for i in $(ls /dev/sd*)
	    do
            if [[ $i != "/dev/sda" ]] && [[ $i != "/dev/sda1" ]] && [[ $i != "/dev/sda2" ]] && [[ $i != "/dev/sda3" ]]
                then
                    a=$(echo $i)
                fi
	    done
    if [[ $a != "0" ]]
        then
            break
        fi
done
b=$(lsblk -o FSTYPE $a)
b=${b/FSTYPE}

case $(echo $b) in
    vfat)
        sudo mount -t vfat $a /media/usb
        ;;
    ntfs)
        sudo mount -t ntfs-3g $a /media/usb
        ;;
    ext4)
        sudo mount -t ext4 $a /media/usb
        ;;
esac 
sudo chmod 777 /media/usb</code></pre>

### Resumen del codigo
Este codigo al inicio crea un bucle que se ejecutara infinitamente hasta que se utilize un `break` dentro de este.
<br>Luego creamos una variable contador llamada `a` que se iniciara con el valor 0 al empezar el bucle.
<br>Dentro del primerbucle creamos un bucle que en cada vuelta guardara en la variable `i` uno de los resultados de utilizar el comando `ls /dev/sd*`, el bucle terminara cuando se hayan acabado los resultados del comando anterior.
<br>Dentro del bucle se comprobara de que el contenido de i no sea igual a las carpetas que estan habitualmente en el servidor sin un usb, en cuanto entre, se le dara a la variable a el valor de i en ese momento.
<br>Fuera del segundo bucle hay un condicional que entrara en el caso de que el valor de a haya cambiado, en el caso de que haya cambiado, se rompera el bucle infinito.
<br>Fuera de los bucles, se crea la variable `b` que guardara el resultado de hacer `lsblk -o FSTYPE $a`, luego filtra el resultado para que solo de el nombre de la partición, y por último hacemos un case que según el tipo de partición del usb se montara con un comando o otro, y ejecutara el script principal.
<br>El script en el caso que no detecte un USB, este estara ejecutandose eternamente hasta que detecte uno, despues de que detecte uno se ejecutaria el codigo principal y cuando el codigo principal se acabe, desmontara la unidad usb y ejecutara de nuevo el codigo.
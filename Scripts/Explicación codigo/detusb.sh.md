# Explicación del codigo detusb.sh

## Explicación de funciones
Este codigo cumple con tres funciones principales 
<li>1. Busca si alguien a insertado un usb a la maquina</li>
<li>2. Lo monta en el equipo</li>
<li>3. Ejecuta scriptfinal.sh</li>

## Explicación del codigo
En el inicio de este codigo abr un bucle que se ejecutara hasta que encuentre un break, también indica en el archivo de registro2.txt que el script ha iniciado y cada vuelta que haga este script, introducira un mensaje, esta funcionalidad es por si por cualquier fallo que pueda ocurrir, saber si este script esta o no en funcionamiento.
```
# !/bin/bash
echo "el script se ha iniciado" >> /home/albert/scripts/registro2.txt
for (( ; ; ));
do
    echo "el script ha dado una vuelta" >> /home/albert/scripts/registro2.txt
    a=0
    sleep 1
```
A continuación dentro del bucle anterior se crea un bucle que mirara todas las unidades introducidas que emiecen por sd y si esta es diferente a las predeterminadas de esta maquina, se supondra de que se a introducido una memoria a la maquina, si hay una memoria, se guardara el nombre que se le ha dado en la variable a.
```
    for i in $(ls /dev/sd*)
	    do
            if [ $i != "/dev/sda" ] && [ $i != "/dev/sda1" ] && [ $i != "/dev/sda2" ] && [ $i != "/dev/sda3" ];
                then
                    a=$(echo $i)
                fi
	    done
```
A continuación se mira si la variabe "a" a cambiado o no de valor, si ha cambiado se le pasa el valor a la variable y hacemos para que b solo se quede con el ultimo caracter de la variable a, luego comprobamos si b es igual a 1, a la variable a se le pondra un 1 al final y se rompe el primer bucle.
```
    if [ $a != "0" ];
    then
        b=${a:-1}
        if [ "$b" == "1" ];
        then
                a=$a"1"
        fi
        echo $a
        break
    fi
done
```
Cuando el primer bucle se ha roto, se monta la unidad en la carpeta /media/usb, se le da todos los permisos, se registra que el script a acabado y ejecutamos el scriptfinal
```
mount $a /media/usb
sudo chmod 777 /media/usb
echo "el script ha finalizado" >> /home/albert/scripts/registro2.txt
sudo bash /home/albert/fin/scriptfinal.sh

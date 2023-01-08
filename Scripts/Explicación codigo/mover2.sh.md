# Explicación del código mover2.sh

## Explicación de funciones
La función principal de este codigo es hacer que los archivos y subcarpetas que esten dentro de la carpeta quarentena pasen directamente el control sin que sean revisados.

## Explicación del codigo
El inicio es el mismo que el del codigo mover, se declaran las variables
```
#! /bin/bash
fin=$1
carp=$2
dir=$3
anali=$4
SQL_USER="usu"
SQL_PASSWORD="passwd"
SQL_DATABASE="usbdb"
direcciones="/home/albert/scripts/direcciones.txt"
```
En esta parte creamos una variable nueva que es SQL_ARGS que lo que hara es que podamos hacer un insert dentro de nuestra base de datos mas adelante, para eso utiliza unas variables anteriores para poder iniciar sesión dentro de la base de datos.
```
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
```
Aqui creamos un bucle el cual miramos todo lo que hay en la carpeta, si es una carpeta la crea en el servidor web y vuelve a ejecutar este script para que analize la carpeta encontrada, y si es un archivo, lo copia al servidor web en la misma carpeta de donde esta, tambien se hace un insert en la base de datos dando los valores del nombre, la ubicación dentro del servidor web y el hash de este archivo.
```
for a in $(ls -1 $dir$fin)
do
	b=${a/" "/"\ "} 
	if [ -d $dir$fin$b ];
	then
		next=""
		next=$fin$b"/"
		echo "directorio"
        mkdir $carp$next
		bash /home/albert/fin/mover2.sh $next $carp $dir $anali
	else
        cp $dir$fin$a $carp$fin$b
		localizacion=$carp$fin$b
		nombre=$b
		id=$(md5sum $dir$fin$b)
		sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5) VALUES ('$nombre', '$localizacion', '$id');"
        sudo mysql $SQL_ARGS "exit"
		echo "El archivo "$nombre" con hash "$id" puede pasar directamente por estar en la carpeta quarentena, puede ser peligroso">>"/home/albert/scripts/registro.txt"
	fi
done
```

# Explicación del código mover.sh

## Explicación de funciones
El script de mover.sh tiene diferentes funciones:
<li>1. Lee toda la carpeta de donde esta</li>
<li>2. Si encuentra un archivo, lo copia y lo pega en la carpeta de analysys correspondiente cambiandole el nombre por su hash y apuntando su lugar de origen en un archivo de direcciones</li>
<li>3. En el caso de que se encuentre una carpeta:
<li>3.1. Si la carpeta se llama quarentena enviara los datos necesarios para abrir el codigo de mover2.sh
<li>3.2. Si la carpeta no se llama quarentena creara dentro de la carpeta de archivos del servidor web, donde le corresponda, esa misma carpeta con el mismo nombre, y enviara los datos necesarios para ejecutarse de nuevo para buscar archivos dentro de la nueva carpeta encontrada</li> 

## Explicación detallada del codigo
El script de mover.sh utiliza 4 variables que le son dadas desde el programa "principal" o desde si mismo, estas 5 variables son:
<li>fin: Guarda la dirección a partir de la raiza del medio</li>
<li>carp: Guarda el nombre de la carpeta creada para ese usb dentro del servidor web</li>
<li>dir: Guarda la dirección del medio normalmente es /media/usb/</li>
<li>anali: Guarda el nombre de la carpeta de analysys donde acabaran los archivos.</li>
<li>direcciones: guarda la dirección fisica del archivo de direcciones
El resto de variables son de apoyo o es para transformar una variable ya existente para mandarsela al siguiente programa

## Explicación del codigo paso a paso
En esta parte del codigo, recoje los datos que se han pasado desde el otro codigo y les da un nombre
```
#! /bin/bash
fin=$1
carp=$2
dir=$3
anali=$4
direcciones="/home/albert/scripts/direcciones.txt"
```
A continuación se habre un bucle que pone en el valor de a una cosa del contenido de la carpeta y cuando ya no tenga mas archivos para que pasen por a el bucle finalizara.
Mas adelante se crea la variable b el cual guardara el valor de a cambiandole el formato luego entra en el condicional que al darle como valor la ruta del archivo completo que serian las variables dir, fin y b, si es un directorio entrara si es un archivo ira al else.
<br>En el caso de que sea un directorio, comprobara si el nombre de la carpeta es quarentena, si es quarentena se creara la carpeta se pondra al final de la bariable b una barra y le enviara las variables b, web, dir y analy para ejecutar el script mover2.sh.
<br>En el caso de que la carpeta no se llame quarentena entra en el else alli se crea la variable next la cual guardara el conjunto de las variables de fin y b, luego crea la carpeta en el servidor web y luego se llama a si mismo enviandole las variables de b, web, dir y analy, para que cambie la carpeta objetivo a revisar.
<br>En el caso de que no fuese una carpeta si no un archivo nos vamos al else, se crea la variable md que guardara el hash md5 del archivo en cuestion, apuntara en el fichero de direcciones la variable de md, luego se transforma la variable md para que solo esten los 32 primeros digitos, los cuales son el hash y por último hace una copia del archivo a la carpeta de analisis y le cambia el nombre del archivo al hash.

```
for a in $(ls -1 $dir$fin)
do
	b=${a/" "/"\ "} 
	if [ -d $dir$fin$b ];
	then
		if [ $b == "quarentena" ]
		then
			mkdir $web$b
            b=$b"/"
            bash /home/albert/fin/mover2.sh $b $web $dir $analy
		else
		next=""
		next=$fin$b"/"
		echo "directorio"
        mkdir $carp$next
		bash /home/albert/fin/mover.sh $next $carp $dir $anali
		fi
	else
		echo "archivo"
		md=$(md5sum $dir$fin$b)
		echo $md >> $direcciones
		#echo $fin$b >> $direcciones
		md=${md:0:32}
        cp $dir$fin$b $anali$md
	fi
done
```
## Explicaciones 
Aquí voy a explicar algunas decisiones de diseño que hay dentro del codigo, o porque he echo según que cosas.
<br>Para empezar en la novena linea que se muestra a continuación, fue un intento del cual intentaba cojer todos los archivos incluso de los cuales tienen espacios en sus nombre, ya que si un archivo o carpeta lleva espacios, el script falla y no lo detecta.
```
b=${a/" "/"\ "} 
```
Lo siguiente a explicar es porque cambio el nombre de los archivos cuando los copio a la carpeta de analisis, esto lo hago porque si el usuario tiene 2 ficheros con contenido diferente pero con el mismo nombre, al copiarlo a la carpeta, el nuevo suplantaria al anterior, asi que lo vi como una mejor idea utilizar este metodo de que el progrma tenga fallas.
<br>
Lo siguiente a explicar es el cambio de formato de la variable md, el problema que existe al hacer el comando md5sum sobre un archivo, reside en que no solo te dice el hash, si no que también te devuelve al lado la dirección de donde esta ubicado el archivo, es por eso que preferi primero escribir el md entero con la dirección en un archivo y luego cambiar el formato.
```
md=$(md5sum $dir$fin$b)
		echo $md >> $direcciones
		#echo $fin$b >> $direcciones
		md=${md:0:32}
        cp $dir$fin$b $anali$md
```
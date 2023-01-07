# Explicación del código mover.sh

## Explicación de funciones
Diferentes funciones script de "mover.sh":
<li>1. Lee  la carpeta de donde está</li>
<li>2. Si encuentra un archivo, lo copia en la carpeta de "análisis" cambiándole el nombre por su hash y apuntando su lugar de origen en un archivo de direcciones</li>
<li>3. Si lo que encuentra es una carpeta:
<li>3.1. Si la carpeta se llama "cuarentena" la abrirá con  "mover2.sh"
<li>3.2. Si la carpeta no se llama "cuarentena",la copiará en "archivos" del servidor web y se  ejecutara de nuevo "mover.sh" para  buscar archivos dentro de la nueva carpeta </li> 

## Explicación detallada del código
El script "mover.sh" utiliza 5 variables dadas desde el programa "principal" o desde sí mismo, estas 5 variables son:
<li>"fin": Guarda la dirección a partir de la raíz del medio</li>
<li>"carp": Guarda el nombre de la carpeta creada para ese usb dentro del servidor web</li>
<li>"dir": Guarda la dirección del medio. La dirección por defecto es /media/usb/</li>
<li>"anali": Guarda el nombre de la carpeta de análisis donde acabarán los archivos.</li>
<li>"direcciones": Guarda la dirección física del archivo de direcciones
El resto de variables son de apoyo o para transformar una variable ya existente y mandársela al siguiente programa

Recoge los datos en la variable correspondiente 
	
```
#! /bin/bash
fin=$1
carp=$2
dir=$3
anali=$4
direcciones="/home/albert/scripts/direcciones.txt"
	
```
	
A continuación se abre un bucle que atribuye a la variable "a" cada elemento de la carpeta .
Se crea la variable "b" en la cual se guarda el valor de "a" cambiándole el formato.
Entra en el condicional al darle como valor la ruta del archivo con las variables "dir", "fin" y "b"
Si es un directorio entrara si es un archivo ira al else.
<li>En el caso de que sea un directorio, comprobara si el nombre de la carpeta es "quarentena", si es así se creara la carpeta y se pondra al final de la bariable "b" una barra. Enviará las variables "b", "web", "dir" y "analy" para ejecutar el script "mover2.sh".</li>
<li>En el caso de que la carpeta no se llame "quarentena" entra en el else:
<br>-Se crea la variable "next" que guardará el conjunto de las variables de "fin" y "b"
<br>-Crea la carpeta en el servidor web, se llama a si mismo y envia las variables "b", "web", "dir" y "analy", para que cambie la carpeta objetivo a revisar.
<li>En el caso de tener un archivo y no una carpeta vamos al else
	<br>Se crea la variable "md" que guardara el hash md5 del archivo , apuntará en el fichero de direcciones la variable de "md", luego transforma la variable "md" para que solo esten los 32 primeros digitos, los cuales son el hash 
	<br>Por último hace una copia del archivo a la carpeta "analisis" y le cambia el nombre del archivo al hash.

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
## Decisiones de diseño 
<br>Para empezar en la novena linea ,Ref.1, es para cojer todos los archivos incluso de los que tienen espacios en sus nombre.
	
	Ref.1
```
b=${a/" "/"\ "} 
```
	
El cambio en el  nombre de los archivos cuando se copian  a la carpeta "analisis",es para que en el caso de que hubiera 2 ficheros de igual nombre pero distinto contenido evitar que uno suplante al otro.
<br>
El cambio de formato de la variable "md", el problema que existe al hacer el comando md5sum sobre un archivo, reside en que no solo te da el hash, si no que también te devuelve al lado la dirección de donde esta ubicado el archivo, es por eso que se escribe el md entero con la dirección en un archivo y luego cambiar el formato.
```
md=$(md5sum $dir$fin$b)
		echo $md >> $direcciones
		#echo $fin$b >> $direcciones
		md=${md:0:32}
        cp $dir$fin$b $anali$md
```

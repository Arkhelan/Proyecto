#! /bin/bash
fin=$1
SQL_HOST=localhost
SQL_USER="usu"
SQL_PASSWORD="2003__Albert"
SQL_DATABASE="usbdb"
carp=$2
dir=$3
anali=$4
usb=$5
direcciones="/home/albert/scripts/direcciones.txt"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
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
		sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb) VALUES ('$nombre', '$localizacion', '$id', '$usb');"
        sudo mysql $SQL_ARGS "exit"
		echo "El archivo "$nombre" con hash "$id" puede pasar directamente por estar en la carpeta quarentena, puede ser peligroso">>"/home/albert/scripts/registro.txt"
	fi
done

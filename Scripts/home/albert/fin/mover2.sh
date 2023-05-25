#! /bin/bash
SQL_HOST=localhost
SQL_USER="usu"
SQL_PASSWORD="2003__Albert"
SQL_DATABASE="usbdb"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
for a in $1/*
do
    b="'$a'"
    if [ -d $b ];
    then
        c=${b:10}
        weba=${2}${c}
        mkdir "$weba"
        bash /home/ubuntu/fin/pruebas/mover2.sh $b $2 $3 $4 $5 $6
    else
        c=${b:10}
        cp $b $2$c
        id=$(md5sum $b)
        id=${id:0:32}
        nombre=${c##*/}
        sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$2$c', '$id', '$4', '$6', '6');"
        sudo mysql $SQL_ARGS "exit"
        echo "El archivo "$nombre" con hash "$id" puede pasar directamente por estar en la carpeta quarentena, puede ser peligroso">>"/var/wwww/html/registro.txt"
    fi
done
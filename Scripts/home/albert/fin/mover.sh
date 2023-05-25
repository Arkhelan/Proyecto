#!/bin/bash
SQL_HOST=localhost
usuario="usu"
clave="2003__Albert"
basedatos="usbdb"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
echo "entro"
for a in "$1"/*
do
    b=${a}
    if [ -d "$a" ];
    then
        echo "carpeta"
        c=${a:10}
        if [[ "$b" == *'quarentena' ]];
        then
            weba=${2}${c}
            mkdir "$weba"
            bash /home/ubuntu/fin/mover2.sh "$b" $2 $3 $4 $5 $6
        else
            weba=${2}${c}
            mkdir "$weba"
            bash /home/ubuntu/fin/mover.sh "$b" $2 $3 $4 $5 $6
        fi
    else
        echo "archivo"
        md=$(md5sum "$b")
        echo $md >> $5
        md=${md:0:32}
        md5=$(mysql -u "$usuario" -p"$clave" "$basedatos" -se "SELECT MD5 FROM archivos WHERE MD5='$md';")
        md5=${md5// /}
        echo $md5
        if [ -z $md5 ]; then
            ac=$3"/"$md
            cp "$b" $ac
        else
            usb=$(mysql -u "$usuario" -p"$clave" "$basedatos" -se "SELECT MD5 FROM archivos WHERE MD5='$md' AND usb='$4';")
            echo $usb
            if [ -z $usb ]; then
                nombre=${b##*/}
                localizacion=$(mysql -u "$usuario" -p"$clave" "$basedatos" -se "SELECT direccion FROM archivos WHERE MD5='$md'")
                localizacion=${localizacion##* }
                peligro=$(mysql -u "$usuario" -p"$clave" "$basedatos" -se "SELECT estado FROM archivos WHERE MD5='$md'")
                if [ $peligro -le "1" ]; then
                    echo "insert"
                    echo "$6"
                    echo "$nombre"
                    mysql -u "$usuario" -p"$clave" "$basedatos" -e "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$4', '$6', '$peligro');"
                elif [ $peligro -eq "2" ]; then
                    mysql -u "$usuario" -p"$clave" "$basedatos" -e "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$4', '$6', '$peligro');"
                elif [ $peligro -eq "3" ]; then
                    mysql -u "$usuario" -p"$clave" "$basedatos" -e "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$4', '$6', '$peligro');"
                elif [ $peligro -eq "4" ]; then
                    mysql -u "$usuario" -p"$clave" "$basedatos" -e "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$4', '$6', '3');"
                else
                    ac=$3"/"$md
                    cp "$b" $ac
                fi
            fi
        fi
    fi
done
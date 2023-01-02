#!/bin/bash
inicio(){
	num=0
	for h in $(ls $arch3)
        do
		num=$(($num + 1))
        done
	val="false"
        for z in $(ls $medio)
        do
                val="true"
        done
}
makedir(){
    web=""
	DIA=`date +"%d.%m.%Y"`
	HORA=`date +"%H:%M:%s"`
	val="false"
	for a in $(ls "/var/www/html/archivos/")
	do
	    if [ "$a" == "$DIA" ];
	    then
        	val="true"
    	fi
	done
	if [ $val=="false" ];
	then
        web="/var/www/html/archivos/"$DIA"/"
	    sudo mkdir $web
	fi
    web="/var/www/html/archivos/"$DIA"/"$HORA"/"
	sudo mkdir $web
}
mover(){
    dir=$medio
    for a in $(ls -1 $dir)
    do
        b=$a
        if [ -d $dir$b ];
        then
            if [ $b == "quarentena" ]
            then
                mkdir $web$b
                b=$b"/"
                bash /home/albert/fin/mover2.sh $b $web $dir $analy
            else
                mkdir $web$b
                b=$b"/"
                bash /home/albert/fin/mover.sh $b $web $dir $analy
            fi
        else
                md=$(md5sum $dir$b)
                echo $md >> $direcciones
		       # echo $a >> $direcciones
                md=${md:0:32}
                cp $dir$b $analy$md
        fi
    done
}
check_deps() {
    # Validate that curl and jq are available
    which curl > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo -ne "You are missing curl, which is required to run this script. Please install curl and try again.\n\n"
        exit 4
    fi

    which jq > /dev/null 2>&1
    if [[ "$?" -ne 0 ]]; then
        echo -ne "You are missing jq, which is required to run this script. Please install jq and try again.\n\n"
        exit 5
    fi
}

vt_file() {
    # Submit a file
    APIKEY="$api"
    FILE=$analy$i
    local FSIZE=$(stat "$FILE" | grep "Size:" | awk '{print $2}')
    if [[ $FSIZE -gt 33554431 ]]; then
      vt_bigfile "$APIKEY" "$FILE"
    else
      curl -o /home/albert/scripts/ids.txt -s --request POST --url "https://www.virustotal.com/api/v3/files" --header "x-apikey: $APIKEY" --form "file=@$FILE"
    fi
}

vt_bigfile() {
    # files > 32M need a special upload URL
    APIKEY="$api"
    FILE=$arch4$i
    URL=$(curl -s --request GET --url "https://www.virustotal.com/api/v3/files/upload_url" --header "x-apikey: $APIKEY" | jq -r .data)
    curl -o /home/albert/scripts/ids.txt -s --request POST --url "$URL" --header "x-apikey: $APIKEY" --form "file=@$FILE"
}

vt_analysis() {
    # Retrieve analysis for a file
    APIKEY="$api"
    FILEID="$a"
    curl -o /home/albert/scripts/analysis.txt -s --request GET --url "https://www.virustotal.com/api/v3/analyses/$FILEID" --header "x-apikey: $APIKEY"
}
api="baf43aeebb9d8efc8bca0db186a65bc70950ac13e94079e04770b71ddfa119ce"
medio="/media/usb/"
scripts="/home/albert/fin/"
arch3="/home/albert/analysis/"
arch2="/home/albert/scripts/"
inicio
analy="$arch3""$num""/"
DIA=`date +"%d/%m/%Y"`
HORA=`date +"%H:%M"`
direcciones="/home/albert/scripts/direcciones.txt"
SQL_HOST=localhost
SQL_USER="usu"
SQL_PASSWORD="2003__Albert"
SQL_DATABASE="usbdb"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
id=""
nombre=""
localizacion=""

vuelta=1
rm $arch2"idsfinal.txt"
rm $arch2"direcciones.txt"
touch $arch2"idsfinal.txt"
touch $arch2"direcciones.txt"
ayuda=false
if [ $val == "true" ]; then
    makedir
    mkdir $analy
    mover
    for i in $(ls -1 $analy)
    do
        bool=false
        for b in $(cat "/home/albert/scripts/whitelist.txt")
        do
            if [ $i == $b ]
            then
                bool=true
            fi
        done
        if [ $bool == "true" ]
        then
         for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                a=$z
                y=${z:0:32}
                if [ $acepto == "true" ];
                then
                    a=${z:11}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    cp $analy$i $web$a
                    acepto=false
                    rm $analy$i
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5) VALUES ('$nombre', '$localizacion', '$id');"
                    sudo mysql $SQL_ARGS "exit"

                fi
                if [ $y == $i ];
                then
                    acepto=true
                    id=$y
                    #echo $a
                fi
            done
        else
            vt_file
            linia=$(sed -n 4p /home/albert/scripts/ids.txt)
		    linia=${linia%?}
		    linia=${linia:15}
            echo $linia >>/home/albert/scripts/idsfinal.txt
            if [ $vuelta == 4 ]
            then
        		vuelta=1
			    sleep 60
        	else
        		vuelta=$(($vuelta + 1))
    		fi
			echo "El archivo "$i" se ha enviado a analizar" >>$arch2"registro.txt"
		fi
    done
    sleep 350
    for a in $(cat "/home/albert/scripts/idsfinal.txt")
	do
		vt_analysis
        ayuda=false
		analys=$(cat $arch2"analysis.txt")
		file=$(ls "$analy" | head -n 1 )
		if [[ $analys == *'malicious": 0,'* ]]; then
        acepto=false
            for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                a=$z
                y=${z:0:32}
                if [ $acepto == "true" ];
                then
                    a=${z:11}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    cp $analy$file $web$a
                    acepto=false
                    rm $analy$file
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5) VALUES ('$nombre', '$localizacion', '$id');"
                    sudo mysql $SQL_ARGS "exit"

                fi
                if [ $y == $file ];
                then
                    acepto=true
                    id=$y
                    #echo $a
                fi
            done
		    echo "El archivo "$file" a sido escaneado y no se ha detectado nada, moviendo el archivo a permitidos" >>$arch2"registro.txt"
		elif [[ $analys == *'malicious": 1,'* ]]; then
            for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                y=${z:0:32}
                if [ $ayuda == "true" ];
                then
                    ayuda=false
                    rm $medio$z
                    mv $z "/var/www/html/archivos/sospechosos/"
                    rm $analy$file
                    ayuda=false
                fi
                if [ $y == $file ];
                then
                    ayuda=true
                fi
            done
            echo "El archivo "$file" a sido escaneado y un antivirus ha detectado algo, por seguridad el archivo sera movido a sospechosos" >>$arch2"registro.txt"
		elif [[ $analys == *'malicious": 2,'* ]]; then
		    for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                y=${z:0:32}
                if [ $ayuda == "true" ];
                then
                    ayuda=false
                    rm $medio$z
                    mv $z "/var/www/html/archivos/sospechosos/"
                    rm $analy$file
                    ayuda=false
                fi
                if [ $y == $file ];
                then
                    ayuda=true
                fi
            done
            echo "El archivo "$file" a sido escaneado y dos antivirus han detectado algo, por seguridad el archivo sera movido a sospechosos" >>$arch2"registro.txt"

		elif [ $analys == *'malicious": 3,'* ]; then
		    for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                y=${z:0:32}
                if [ $ayuda == "true" ];
                then
                    ayuda=false
                    rm $medio$z
                    mv $z "/var/www/html/archivos/sospechosos/"
                    rm $analy$file
                    ayuda=false
                fi
                if [ $y == $file ];
                then
                    ayuda=true
                fi
            done
            echo "El archivo "$file" a sido escaneado y tres antivirus han detectado algo, por seguridad el archivo sera movido a sospechosos" >>$arch2"registro.txt"
		else
		    echo "El archivo "$file" a sido escaneado y mas de tres antivirus han dado positivo, el archivo por seguridad sera movido a prohibidos" >>$arch2"registro.txt"
		    for z in $(cat "/home/albert/scripts/direcciones.txt")
            do
                y=${z:0:32}
                if [ $ayuda == "true" ];
                then
                    ayuda=false
                    mv $z "/var/www/html/archivos/prohibidos/"
                    rm $analy$file 
                fi
                if [ $y == $file ];
                then
                    ayuda=true
                fi
            done
		fi
	done
else
    echo "No se localizo ningún archivo en la carpeta" >>$arch2"registro.txt"
fi
sudo umount /media/usb

#Deberias crear un script que determine que el usuario a sacado el usb antes de volver a ejecutar el usb de detección.
bash /home/albert/fin/detusb.sh

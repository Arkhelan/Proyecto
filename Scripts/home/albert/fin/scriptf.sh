# !/bin/bash
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
    dir=$medio"*"
    for a in $dir
    do
        b=$a
        echo $b
        if [ -d "$b" ];
        then
            c=${a:11}
            if [[ "$b" == *'/quarentena' ]];
            then
                weba="${web}${c}"
                mkdir "$weba"
                bash /home/ubuntu/fin/mover2.sh "$b" $web $analy $usb $direcciones $analisys
            else
                b=${a}
                echo "carpeta"
                echo $web$c
                weba="${web}${c}"
                mkdir "$weba"
                bash /home/ubuntu/fin/mover.sh "$b" $web $analy $usb $direcciones $analisys
               # bash /home/ubuntu/fin/ssh2.sh "$b" $web $analy $usb $direcciones
            fi
        else
                echo "no"
                md=$(md5sum "$ja")
                echo $md >> $direcciones
		       # echo $a >> $direcciones
                md=${md:0:32}
                cp "$b" $analy$md
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
    FILE="$analy$i"
    echo $analy $i
    local FSIZE=$(stat "$FILE" | grep "Size:" | awk '{print $2}')
    if [[ $FSIZE -gt 33554431 ]]; then
      vt_bigfile "$APIKEY" "$FILE"
    else
      curl -o /home/ubuntu/scripts/idsp.txt -s --request POST --url "https://www.virustotal.com/api/v3/files" --header "x-apikey: $APIKEY" --form "file=@$FILE"
    fi
}
vt_bigfile() {
    # files > 32M need a special upload URL
    APIKEY="$api"
    FILE=$analy$i
    URL=$(curl -s --request GET --url "https://www.virustotal.com/api/v3/files/upload_url" --header "x-apikey: $APIKEY" | jq -r .data)
    curl -o /home/ubuntu/scripts/idsp.txt -s --request POST --url "$URL" --header "x-apikey: $APIKEY" --form "file=@$FILE"
}

vt_analysis() {
    # Retrieve analysis for a file
    APIKEY="$api"
    FILEID="$a"
    curl -o /home/ubuntu/scripts/analysis.txt -s --request GET --url "https://www.virustotal.com/api/v3/analyses/$FILEID" --header "x-apikey: $APIKEY"
}
echo "inicia el fin"
api="8271f4863be193249122e64aa706cd983b0415931ad24dc66e36443dabe8cc78"
medio="/media/usb/"
usb=$1
scripts="/home/ubuntu/fin/"
arch3="/home/ubuntu/analysis/"
arch2="/home/ubuntu/scripts/"
#Ejecutamos la función de inicio
inicio
echo $1
analy="$arch3""$num""/"
DIA=`date +"%d/%m/%Y"`
HORA=`date +"%H:%M"`
direcciones="/home/ubuntu/scripts/direcciones.txt"
SQL_HOST=localhost
SQL_USER="usu"
SQL_PASSWORD="2003__Albert"
SQL_DATABASE="usbdb"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD -D $SQL_DATABASE -s -e"
id=""
echo $2
reg="/var/www/html/registro.txt"
nombre=""
localizacion=""
unidad=$2
vuelta=1
#Eliminamos archivos del analisis anterior y los volvemos a crear
rm $arch2"idsfinal.txt"
rm $arch2"direcciones.txt"
touch $arch2"idsfinal.txt"
touch $arch2"direcciones.txt"
#Variable booleana para proximamente
ayuda=false
#Solo entrara en este condicionale en el caso de que hayan archivos o directorios dentro del usb
if [ $val == "true" ]; then
    fecha=$(date +%Y:%m:%d)
    echo "aqui"
    sudo mysql $SQL_ARGS "INSERT INTO analisys(id_usb, fecha) VALUES ('$1', '$fecha');"
    sudo mysql $SQL_ARGS "exit"
    analisys=$(sudo mysql $SQL_ARGS "SELECT MAX(idanaly) FROM analisys";)
    #Iniciamos 2 funciones, la priemra sirve para crear la carpeta dentro del servidor web, y la segunda
    #sirve para mover todos los archivos a la carpeta creada en la linea de encima
    makedir
    echo $analisys
    mkdir $analy
    mover
    #Ahora hacemos un bucle que va a poner nombre por nombre de lo que encuentre en i
    #Recordatorio, esto es un ls y no solo la ruta directamente porque el nombre es el hash del archivo
    for i in $(ls -1 $analy)
    do
        bool=false
        #El siguiente bucle sirve para confirmar si el hash del archivo coincido con alguno de los que esta admitido por la mejora personal
        #de quarentena, esta mejora se implemento antes de la carpeta quarentena.
        for b in $(cat "/home/ubuntu/scripts/whitelist.txt")
        do
            if [ $i == $b ]
            then
                bool=true
            fi
        done
        if [ $bool == "true" ]
        then
         for z in $(cat "/home/ubuntu/scripts/direcciones.txt")
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
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$id', '$usb');"
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
            #Ahora que los archivos que estan permitidos ya han pasado, toca analizar los que no estan en la carpeta de quarentena
            #o su hash no esta en la lista de permetidos
            vt_file
            #Las lineas de a continuación sirven para filtrar la ID del archivo del resto de contenido del archivo
            #y enviarlo al final del archivo de idsfinal.txt
            linia=$(sed -n 4p /home/ubuntu/scripts/idsp.txt)
		    linia=${linia%??}
		    linia=${linia:15}
            echo $linia
            echo $linia >>"/home/ubuntu/scripts/idsfinal.txt"
            #Como la limitación de Virus Total es de 4 archivos, por cada 4 archivos se parara durante 1 minuto
            if [ $vuelta == 4 ]
            then
        		vuelta=1
			    sleep 60
        	else
        		vuelta=$(($vuelta + 1))
    		fi
			echo "El archivo "$i" se ha enviado a analizar" >>$reg
		fi
    done
    echo "acabe"
    sleep 60
    #Cuando todos los archivos se han enviado a analizar y tenemos las ID, esperamos 1 minuto y consultamos el resultado
    for a in $(cat /home/ubuntu/scripts/idsfinal.txt)
	do
		vt_analysis
        echo $a
        ayuda=false
        #En esta variable se guardara todo el contenido del analysis
		analys=$(cat $arch2"analysis.txt")
        #En esta se guardara el nombre del primer archivo al hacer un ls, esto se hace ya que como fueron enviados a analizar por orden
        #el id de analizar tambien estara por orden dentro del archivo
		file=$(ls "$analy" | head -n 1 )
        #A continuación se buscara dentro del archivo si malicious es 0 1 o 2, esto determinara si es peligroso o hay que tener cuidado
        #si es mas que 2 es peligroso y no pasara de aqui.
		if [[ $analys == *'malicious": 0,'* ]]; then
        acepto=false
        echo "entra"
            while read -r z
            do
                echo "algo"
                a=$z
                y=${z:0:32}
                #Aqui se buscara en el archivo de direcciones la linea que coincida con el archivo
                #Me he quedado aqui
                if [[ $y == $file ]];
                then
                    a=${z:44}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    echo $analy$file
                    echo $web$a
                    md=$(md5sum "$analy$file")
                    md=${md:0:32}
                    cp $analy$file "$web$a"
                    acepto=false
                    rm $analy$file
                    echo $nombre
                    echo $localizacion
                    echo $md
                    echo $usb
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$usb', '$analisys', '1');"
                    sudo mysql $SQL_ARGS "exit"

                fi
            done < "$direcciones"
            echo "salio"
		    echo "El archivo "$file" a sido escaneado y no se ha detectado nada, moviendo el archivo a permitidos" >>$reg
		elif [[ $analys == *'malicious": 1,'* ]]; then
            while read -r z
            do
                echo "algo"
                a=$z
                y=${z:0:32}
                #Aqui se buscara en el archivo de direcciones la linea que coincida con el archivo
                #Me he quedado aqui
                if [[ $y == $file ]];
                then
                    a=${z:44}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    echo $analy$file
                    echo $web$a
                    md=$(md5sum "$analy$file")
                    md=${md:0:32}
                    cp $analy$file "$web$a"
                    acepto=false
                    rm $analy$file
                    echo $nombre
                    echo $localizacion
                    echo $md
                    echo $usb
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$usb', '$analisys', '2');"
                    sudo mysql $SQL_ARGS "exit"

                fi
            done < "$direcciones"
            echo "El archivo "$file" a sido escaneado y un antivirus ha detectado algo, el archivo sera utilizable, tengan precaución" >>$reg
		elif [[ $analys == *'malicious": 2,'* ]]; then
		    while read -r z
            do
                echo "algo"
                a=$z
                y=${z:0:32}
                #Aqui se buscara en el archivo de direcciones la linea que coincida con el archivo
                #Me he quedado aqui
                if [[ $y == $file ]];
                then
                    a=${z:44}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    echo $analy$file
                    echo $web$a
                    md=$(md5sum "$analy$file")
                    md=${md:0:32}
                    cp $analy$file "$web$a"
                    acepto=false
                    rm $analy$file
                    echo $nombre
                    echo $localizacion
                    echo $md
                    echo $usb
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$usb', '$analisys', '2');"
                    sudo mysql $SQL_ARGS "exit"

                fi
            done < "$direcciones"
            echo "El archivo "$file" a sido escaneado y un antivirus ha detectado algo, el archivo sera utilizable, tengan precaución" >>$reg

		elif [[ $analys == *'malicious": 3,'* ]]; then
		    while read -r z
            do
                echo "algo"
                a=$z
                y=${z:0:32}
                #Aqui se buscara en el archivo de direcciones la linea que coincida con el archivo
                #Me he quedado aqui
                if [[ $y == $file ]];
                then
                    a=${z:44}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    echo $analy$file
                    echo $web$a
                    md=$(md5sum "$analy$file")
                    md=${md:0:32}
                    cp $analy$file "$web$a"
                    acepto=false
                    rm $analy$file
                    echo $nombre
                    echo $localizacion
                    echo $md
                    echo $usb
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$usb', '$analisys', '2');"
                    sudo mysql $SQL_ARGS "exit"

                fi
            done < "$direcciones"
            echo "El archivo "$file" a sido escaneado y un antivirus ha detectado algo, el archivo sera utilizable, tengan precaución" >>$reg
		else
		    echo "El archivo "$file" a sido escaneado y mas de tres antivirus han dado positivo, el archivo por seguridad no sera visible al usuario" >>$reg
		    while read -r z
            do
                echo "algo"
                a=$z
                y=${z:0:32}
                #Aqui se buscara en el archivo de direcciones la linea que coincida con el archivo
                #Me he quedado aqui
                if [[ $y == $file ]];
                then
                    a=${z:44}
                    eliminar=${z:33}
                    nombre=$web$a
                    localizacion=${nombre:13}
                    nombre=${nombre##*/}
                    echo $analy$file
                    echo $web$a
                    md=$(md5sum "$analy$file")
                    md=${md:0:32}
                    cp $analy$file "$web$a"
                    acepto=false
                    rm "$analy$file"
                    rm "$eliminar"
                    echo "Elimino "$eliminar
                    echo $nombre
                    echo $localizacion
                    echo $md
                    echo $usb
                    sudo mysql $SQL_ARGS "INSERT INTO archivos (nombre, direccion, MD5, usb, idanaly, estado) VALUES ('$nombre', '$localizacion', '$md', '$usb', '$analisys', '3');"
                    sudo mysql $SQL_ARGS "exit"

                fi
            done < "$direcciones"
            echo "El archivo "$file" a sido escaneado y un antivirus ha detectado algo, el archivo sera utilizable, tengan precaución" >>$reg
		fi
	done
fi
name=$2
mame=${name:0:-1}
echo $name
echo $mame
count=0
#sudo umount /media/usb
echo $(ls /dev/sd*)
for (( ; ; ));
do
    count=0
#    echo "el script ha dado una vuelta" >> /home/ubuntu/scripts/registro2.txt
    a=0
    sleep 1
    for i in $(ls /dev/sd*)
	    do
            if [ $i == $name ] || [ $i == $mame ];
                then
                   count=$(($count + 1))
                fi
	    done
    if [ $count == "0" ];
    then
        echo "El usb se ha quitado"
        break
    fi
done
sudo bash /home/ubuntu/fin/detecto.sh
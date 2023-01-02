#! /bin/bash
fin=$1
carp=$2
dir=$3
anali=$4
direcciones="/home/albert/scripts/direcciones.txt"
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


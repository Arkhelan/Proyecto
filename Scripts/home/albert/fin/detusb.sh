# !/bin/bash
echo "el script se ha iniciado" >> /home/albert/scripts/registro2.txt
for (( ; ; ));
do
    echo "el script ha dado una vuelta" >> /home/albert/scripts/registro2.txt
    a=0
    sleep 1
    for i in $(ls /dev/sd*)
	    do
            if [ $i != "/dev/sda" ] && [ $i != "/dev/sda1" ] && [ $i != "/dev/sda2" ] && [ $i != "/dev/sda3" ];
                then
                    a=$(echo $i)
                fi
	    done
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
mount $a /media/usb
sudo chmod 777 /media/usb
echo "el script ha finalizado" >> /home/albert/scripts/registro2.txt
sudo bash /home/albert/fin/scriptfinal.sh

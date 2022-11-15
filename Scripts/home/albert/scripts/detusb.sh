# !/bin/bash
for (( ; ; ))
do
a=0
    for i in $(ls /dev/sd*)
	    do
            if [[ $i != "/dev/sda" ]] && [[ $i != "/dev/sda1" ]] && [[ $i != "/dev/sda2" ]] && [[ $i != "/dev/sda3" ]]
                then
                    a=$(echo $i)
                fi
	    done
    if [[ $a != "0" ]]
        then
            echo $a
            break
        fi
done
b=$(lsblk -o FSTYPE $a)
b=${b/FSTYPE}

case $(echo $b) in
    vfat)
        sudo mount -t vfat $a /media/usb
        ;;
    ntfs)
        sudo mount -t ntfs-3g $a /media/usb
        ;;
    ext4)
        sudo mount -t ext4 $a /media/usb
        ;;
esac 
sudo chmod 777 /media/usb

# Explicación de codigo inicio.sh
## Proposito
Este es un codigo simple el cual para lo único que sirve es para ejecutar el codigo detusb.sh 60 segundos despues de que el sistema operativo se encienda, esto sirve para prevenir errores que podrían pasar si se ejecutara directamente el script detusb.sh
```
#! /bin/bash
echo "El primer script se ha iniciado" >> /home/albert/fin/registro2.txt
sleep 60
echo "se va a iniciar el script detusb.sh" >> /home/albert/fin/registro2.txt
sudo bash /home/albert/fin/detusb.sh
```
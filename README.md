#Instalación MySql
Actualización del sistema :

  sudo apt update && sudo apt upgrade
  
Comando instalacion  MySql
  sudo apt install mysql-server mysql-client --fix-broken --fix-missing
    
Vemos la versión MySql
  mysql --version
Una vez completada la instalación, puede proteger el servidor MySQL ejecutando el siguiente comando:

  sudo mysql_secure_installation 
  
Pasará por un asistente de preguntas para asegurar el servidor MySQL. Siga las instrucciones en pantalla a continuación.
Presione " y " para habilitar el complemento de validación de contraseña. Esto le permitirá establecer una política estricta de contraseñas para las cuentas

La contraseña configurada anteriormente para las cuentas raíz solo se usa para usuarios remotos. Para iniciar sesión desde el mismo sistema, escriba mysql en la terminal:
      Contraseña: Zxc%1234

Accedemos a MySql
    sudo mysql 
    
Cramos una base de datos llamada 'alodb':
        mysql> CREATE DATABASE mydb; 
        
Luego, cramos un usuario llamado 'myuseralo' accesible solo desde 'localhost':

        mysql> CREATE USER 'myuseralo'@'localhost' IDENTIFIED BY 'secure_password_'; 
        
Otorguo permisos de base de datos al usuario:

        mysql> GRANT ALL ON alodb.* to 'myuseralo'@'localhost'; 
        
 Aplicar los cambios de permisos en tiempo de ejecución:
                
        mysql> FLUSH PRIVILEGES; 
        
   
   
        
Administrar el servicio MySQL
Para comprobar el estado del servidor de la base de datos:
        





 Desinstalar MySql
    sudo apt autoremove --purge mysql-server
    sudo apt-get remove --purge mysql-server mysql-client mysql-common
    sudo apt-get autoclean
    sudo apt-get autoremove
    sudo rm -rf /var/lib/mysql

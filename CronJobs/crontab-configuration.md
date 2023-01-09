Para que nos funcionen los scripts, necesitaremos el permiso sudo de administrador, asi que para editar crontab utilizaremos el siguiente comando:
```
sudo crontab -e
```
Al hacer esto deberia abrirnos la tabla cron.

A continuación escribiremos esto en la última linea:
```
@reboot bash /home/albert/fin/inicio.sh
```

Aquí lo que le estamos indcando que haga es que se ejecute una vez cada vez que el sistema se encienda.
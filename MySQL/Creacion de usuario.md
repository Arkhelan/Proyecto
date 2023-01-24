### Crear un usuario con pribilegios en MySQL
Hicimos todas las ediciones en MySQL como usuario root con pleno acceso a todas las bases de datos. 
Sin embargo,hay casos en que se requieren  restricciones, por lo que hemos de crear un usuario con permisos personalizados.
Comencemos creando un nuevo usuario en el shell de MySQL:

 mysql> <pre><code>CREATE USER 'almanDB'@'localhost' IDENTIFIED BY 'Alm@n123';</pre></code>
 
 En este momento, almanDB no tiene permisos para hacer nada con las bases de datos. 
 De hecho, incluso si almanDB intenta iniciar sesión (con la contraseña, password), no podrá acceder al shell de MySQL.
 Por lo tanto, lo primero que se debe hacer es proporcionar al usuario acceso a la información que necesitará.
 
 mysql> <pre><code>GRANT ALL PRIVILEGES ON * . * TO 'almanDB'@'localhost';</pre></code>
 
 Los asteriscos se refieren a la base de datos y la tabla (respectivamente) a los que pueden acceder. 
 Este comando específico permite al usuario leer, editar, ejecutar y realizar todas las tareas en todas las bases de datos y tablas.
 Estamos otorgando a almanDB acceso de root completo a todo en nuestra base de datos.
 ### Cargar todos los privilegios
 
  mysql> <pre><code>FLUSH PRIVILEGES;</pre></code>
 
### Para proporcionar un permiso a un usuario específico
   mysql> <pre><code>GRANT type_of_permission ON database_name.table_name TO 'username'@'localhost';</pre></code>
   
### Revocar un permiso
  mysql> <pre><code>REVOKE type_of_permission ON database_name.table_name FROM 'username'@'localhost';</pre></code>
 
### Revisar los permisos actuales de un usuario 
  mysql> <pre><code>SHOW GRANTS FOR 'username'@'localhost';</pre></code>
  
### Eliminar un usuario por completo
  mysql> <pre><code>DROP USER 'username'@'localhost';</pre></code>
 
### Cerrar sesion de usuario 
  mysql> <pre><code>quit</pre></code>
  
### Iniciar sesion con un usuario
  <pre><code>mysql -u [username] -p</pre></code>



 


 

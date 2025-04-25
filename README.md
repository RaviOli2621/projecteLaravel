# Diferencias destacables con el funcionamiento respeto al proyecto anteiror

## QR
-En la vista del articulo en grande no se puede copiar los datos del articulo en uno nuevo para tener una plantilla

-El ajax del qr solo se encuentra en el modal con el qr de un articulo ya generado. Esto sucede porque la vista para ver el articulo en completo funciona por el id del articulo, no or sus campos.

## Contraseña

Un usuario logueado por oauth puede cambiar la contraseña sin problemas

# Paginacion

Ahora se puede ordenar por cuerpo tambien

# Detalles a resaltar en el proceso de creacion del proyecto
-La pagina no es una recreacion de la practica nativa de php, es un proyecto en laravel el cual importa la mayoria de caracteristicas del proyecto anterior

-A la hora de hacer la validacion del jwt para la api, se tuvo que crear un middleware para verificar que el jwt es valido (se siguen guardando los mismos datos, el correo y si el usuario es administrador)

# Usuarios 

correo                      nombre                      contraseña      esadmin
Aihnoa                      azaluda@sapalomera.cat      P@ssword        no
Paco                        paco@gmail.com              P@ssw0rd        no
Ravi 2621_20250418eede      ravirubio2621@gmail.com     P@ssw0rd        no
(hecho con oauth)
Xavi                        j.rubio2@sapalomera.cat     P@ssw0rd        si
XaviProfe                   xmartin@sapalomera.cat      P@ssw0rd        si

# Como iniciar el proyecto

1. Añade el proyecto al www
2. Añade la bd al laragon. En la carpeta database tienes: el sql que importe al proyecto "oldPt06_xavi_rubio.sql" y el actual "pt06_xavi_rubio.sql". La version "old" tendra las
   contraseñas mal asi que se recomienda hacer login por oauth con alguna cuenta y cambiar la contraseña(si necesitas el admin) o si no crear una nueva.
3. Inicia el laragon
4. En la terminal desde el proyecto ejecuta "php artisan serve". El metodo de inicio de la aplicacn se tuvo que modificar para poder usar oauth. Si no te molesta que 
   no funcione oauth ves al .env y comenta el BASE_URL actual y descomenta el que estaba comentado para que funcione por projecte.test


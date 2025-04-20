# Diferencias destacables con el funcionamiento respeto al proyecto anteiror

## QR
-En la vista del articulo en grande no se puede copiar los datos del articulo en uno nuevo para tener una plantilla

-El ajax del qr solo se encuentra en el modal con el qr de un articulo ya generado. Esto sucede porque la vista para ver el articulo en completo funciona por el id del articulo, no or sus campos.

# Detalles a resaltar en el proceso de creacion del proyecto
-La pagina no es una recreacion de la practica nativa de php, es un proyecto en laravel el cual importa la mayoria de caracteristicas del proyecto anterior

-A la hora de hacer la validacion del jwt para la api, se tuvo que crear un middleware para verificar que el jwt es valido (se siguen guardando los mismos datos, el correo y si el usuario es administrador)
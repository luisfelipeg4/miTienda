
# Mi tienda 
Por : Luis Felipe Garcia Herrera 

## Sobre la APP

La aplicación te permite crear,leer,modificar,elimiar,listar productos que luego pueden ser ubicados por un usuario para que el mismo pueda comprarlo. una vez el usuario haya creado el producto, tiene la opción de comprarlos en la página principal de la applicación, cuando el usuario seleccione un producto lo llevara a la vista en la cual agregará los datos del pagador y creará una Orden, el sistema lo redirigirá a otra vista donde puede observar todas las Ordenes con sus estados, con la ópcion de observar el resumen y en dicha vista es donde tiene la ópcion de pagar el cual será redirigido al WebCheckOut de PlaceToPay, una vez el usuario termina el proceso de pago lo retorna hacia el resumen de la orden donde podrá observar el estado del pago. 

## Instalación 

Ates de la instalación asegurarnos de que tengamos instalado :
- PHP 
- MySQL
- Composer

Para el correcto funcionamiento de la app es necesario crear la BD en mysql y correrlo en el puerto por defecto 3306
(mariaDB en su defecto)
```sql
$ mysql -u root -p
$ create database prueba_tecnica;
$ grant all on prueba_tecnica.* to miTienda@localhost identified by "admin";
$ grant all on prueba_tecnica.* to miTienda@'%' identified by "admin";
```
Configuracion de entorno .env
```sh
$ cp .env.example .env
```
Para el siguiente comando debes de tener instalado composer [Composer](https://getcomposer.org/doc/00-intro.md) 
```sh
$ composer update
```
Realizar las migraciones de la base de datos 
```sh
$ php artisan migrate 
```
Ejecutar el servidor y este correrá en el http://localhost:8000/
```sh
$ php artisan serve
```
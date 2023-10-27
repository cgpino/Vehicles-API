# Vehicles-API
API básica desarrollada con PHP Symfony que permite realizar distintas operaciones con una base de datos de vehículos.

## Requisitos
* PHP 8.2.
* Symfony 6.3 y Symfony CLI.
* Composer.
* Servidor de Base de datos (externo o en local).
* Postman o Insomnia (para poder probarla externamente a otra aplicación que la consuma).

## Instalar el proyecto
* Clonar o descargar este repositorio
* Abrir una terminal en el directorio raíz del proyecto.
* Ejecutar el comando `composer install` en el directorio raíz del proyecto para instalar todas las dependencias del mismo.
* Arrancar un servidor local o externo con MySQL. Para el desarrollo se ha usado el servidor de BBDD que proporciona `XAMPP` con el panel `phpmyadmin`.
* Configurar la conexión de la aplicación con el servidor de Base de Datos, para ello debemos abrir el archivo `.env` situado en la raíz y editar el valor de la variable `DATABASE_URL`, debemos indicar el tipo de BBDD, la ip (127.0.0.1 si es local), el puerto, usuario y contraseña (en caso de haberlas), el nombre de la BBDD que vamos a crear (en el caso por defecto `vehicles_db`) y la versión del servidor. En el propio archivo `.env` ya hay un ejemplo de conexión por defecto (la que se ha usado para el desarollo), debemos comentarla y añadir la conexión propia a nuestra BBDD.
* Generar la Base de datos y llevarla a la última versión de las migraciones, para ello debemos ejecutar los comandos `php bin/console doctrine:database:create` y `php bin/console doctrine:schema:update --force` respectivamente en la raíz del proyecto.
* Arrancar el servidor de la aplicación API, ejecutando el comando el comando `php bin/console server:run` en la raíz del proyecto, con ello tendremos la aplicación corriendo en `http://127.0.0.1:8000`.

## ¿Cómo se usa?
Una vez instalada y arrancada la aplicación, para poder probarla podemos usar algún servicio que permita realizar peticiones *GET*, *POST*, *PUT* y *DELETE* a una dirección IP, como por ejemplo Postman o Insomnia.

## Funciones de la API

| Función | Método | Dirección | Parámetros GET | Parámetros POST | Descripción |
| --- | --- | --- | --- | --- | --- |
| **vehicles_lists** | `GET` | /api/vehicles | Ninguno | Ninguno | Devuelve el listado completo de vehículos que aún no se hayan vendido (sold = false). |
| **vehicle_detail** | `GET` | /api/vehicles/{id} | `id`: id del vehículo que se desea visitar. | Ninguno | Devuelve los datos del vehículo específicado por id. |
| **vehicle_create** | `POST` | /api/vehicles | Ninguno | `plate` (matrícula), `model` (modelo de coche), `brand` (marca), `color`, `image_path` (url de la imagen) y `price` (precio) | Crea un nuevo vehículo con los parámetros facilitados por POST. |
| **vehicle_reregister** | `PUT` | /api/vehicles/plate/{id} | `id`: id del vehículo que se desea rematricular. | `plate`: nueva matrícula para el vehículo. | Modifica la matrícula actual del vehículo especificado por id. |
| **sell_vehicle** | `PUT` | /api/vehicles/sell/{id} | `id`: id del vehículo que se desea vender. | Ninguno | Marca como vendido el vehículo especificado por id. |

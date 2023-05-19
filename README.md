# Prueba Tecnica de 789

Este sistema de ToDo's es una prueba tecnica para la empresa 789.mx
Para poder correr el sistema solo debe seguir las siguientes intrucciones y tener los requerimientos

Requerimientos:

-   PHP (Mayor o igual a la versión 8.1)
-   MySQL (Mayor o igual a la versión 8)
-   Servidor Apache o Nginx instalado
-   Composer (Mayor o igual a la versión 2.5)

Instrucciones:

1. Clonar este proyecto

```bash
$ git clone https://github.com/dorkyeti/prueba-tecnica-789mx.git
```

2. Copiar el `.env.example` a `.env`
3. Cambiar los valores de `.env` con los valores de su base de datos
4. Instalar las depedencias de composer

```bash
$ composer install --no-dev
```

5.  Generar la `APP_KEY` del proyecto

```bash
$ php artisan key:generate
```

6. Correr las migraciones junto con los seeders

```bash
$ php artisan migrate --seed
```

7. Apuntar la el servidor a la carpeta `/public` del proyecto

```
/path/to/project/public
```

8. Ir a la url de la aplicación.

9. Ingresar o registrarse

-   Ingresar como administrador con las siguientes credenciales

```
Email: admin@mail.com
Password: password
```

-   Registrarse como un nuevo usuario operador

10. Registrar sus ToDos

Nota: El proyecto usa los cdns de algunas librerias, asi que es recomendable correrlo con conexión a internet
<a href="https://www.flaticon.com/free-icons/list" title="list icons">List icons created by Freepik - Flaticon</a>

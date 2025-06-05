# Instalación
Para instalar este proyecto debes clonar el repositorio en algún lugar de tu equipo, después deberás ejecutar los siguientes pasos:

### Creación de base de datos
Crear una base de datos en tu equipo local con charset UTF-8 y uso de InnoDB.

### Instalar dependencias
En la carpeta del proyecto ejecutar el comando `composer install` para instalar dependencias asociadas al proyecto.

### Configurar entorno
Copiar el archivo `.env.example` a uno llamado `.env`, **IMPORTANTE NO RENOMBRARLO** y después configurar colocando las credenciales de la base de datos.
Después generar una clave de encriptación usando el comando `php artisan key:generate`

### Ejecutar migraciones y seeders
Ejecutar el comando `php artisan migrate --seed` para crear las tablas de la base de datos e insertar sus datos default.
Una de estas migraciones y el seeder insertará los siguientes datos:

- Usuario administrador root: El usuario root del sistema
    - Email: javierleon@hecco.mx
    - Password: adminroot
- Usuario encargado 1: Usuario con rol de encargado
    - Email: `abraham@emeefe.mx`
    - Password: `12345678`
- Usuario encargado 2: Usuario con rol de encargado
    - Email: `angelica.h@mundofrio.com.mx`
    - Password: `12345678`

Además se insertarán universidades, carreras y programas default.

# Tecnologías usadas
Este proyecto se trabaja con el modelo vista controlador usado normálmente por Laravel por lo que la mayoría de información se debería encontrar en su documentación, en específico documentación de la versión [5.8](https://laravel.com/docs/5.8).

Además de esto se incluyen algunos paquetes para solucionar algunos problemas o mejorar el funcionamiento, estos se listan a continuación:

- [Laratrust 5.2](https://laratrust.santigarcor.me/docs/5.2/): Permite manejar roles y permisos, con este paquete se asignan roles a practicantes, encargados, etc.
- [Easy Sweet Alert Messages for Laravel](https://github.com/uxweb/sweet-alert): Permite mostrar mensajes de alerta con SweetAlert de Javascript manejandolo desde el backend.

Además Laravel tiene la posibilidad de integrar componentes de Vue y esto se puede ver en su [documentación](https://laravel.com/docs/5.8/frontend#writing-vue-components), para implementar nuevos componentes se deben instalar antes las dependencias en la raíz del proyecto usando el comando `yarn install`.
Los paquetes instalados en el frontend son los siguientes:

- [Axios](https://github.com/axios/axios): Permite realizar peticiones HTTP devolviendo promesas, esta librería debe ser usada al hacer peticiones
- [Bootstrap Vue](https://bootstrap-vue.org/): Componentes de Bootstrap 4 para Vue, el proyecto usa Bootstrap 4 y se pueden usar tanto estos componentes como las estructuras HTML de la documentación de [Bootstrap 4](https://getbootstrap.com/docs/4.0/components/alerts/) 
- [Vue 2 Datepicker](https://www.npmjs.com/package/vue2-datepicker): Componente Datepicker para Vue, permite elegir fechas, rangos de fechas, etc.
- [Sweet Alert](https://sweetalert.js.org/guides/): Libreria javascript para mostrar alertas, esta se instala debido a que se usa un paquete para Laravel que muestre alertas, entonces también se debe usar para aprovechar su funcionamiento e inclusión.
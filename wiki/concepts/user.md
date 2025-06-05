# Usuario
Un usuario es una persona registrada en el sistema y puede o no acceder a él, un usuario siempre debe tener por lo menos un rol que le dejará gestionar ciertas secciones del sistema.

Los usuarios se manejan por default con la funcionalidad de Laravel por lo que todo lo que se encuentre en la documentación acerca de usuarios funcionará normalmente.

Los datos que tiene un usuario son los siguientes:

- Nombre y apellidos
- Email: Único en todo el sistema
- Contraseña
- PIN: Solo útil cuando el usuario es practicante o se necesitan contabilizar sus horas, además debe estar activo.
- Teléfono: Dato no requerido para todos los tipos de usuario
- Nombre y teléfono del contacto de emergencia: No requeridos para todos los tipos de usuario
- Dirección: Dirección en una sola línea
- Área: Área a la que pertenece el usuario, usable para practicantes o candidatos
- Skype: Cuenta de skype cuando la modalidad de entrevistas es remota
- Estatus **Por implementar**: Estatus del usuario
    - Active: El usuario se encuentra activo dentro del sistema, todas las funcionalidades de su rol están disponibles
    - Locked: El usuario se encuentra bloqueado por RAMA ya sea porque era un trabajador de RAMA y ya no labora o por cualquier motivo en el que se necesita bloquear el acceso al usuario.
    - Disabled: La cuenta del usuario se encuentra desabilitada debido a que el usuario ya no se encuentra en RAMA, se diferencia de `Locked` en que un usuario desabilitado pudo ser un practicante y haber terminado su periodo, además las marcas o indicadores en el sistema son menos fuertes con este caso que con `Locked`
# Roles
El sistema cuenta con diversos roles gestionados por el paquete Laratrust, los roles permiten restringir ciertas áreas o acciones dependiendo el usuario logueado, en esta sección se documentan los roles disponibles y sus alcances.

## Uso del paquete
La documentación del paquete es muy amplia y se debe acudir a ella para resolver otras dudas no documentadas en esta sección. Se creó un modelo `App\Role` que hereda del modelo base del paquete para poder acceder a él más fácilmente y extender su funcionalidad, además se crearon constantes con el prefijo `ROL_*` para almacenar los nombres de los roles y hacer uso por medio de estas constantes en lugar de strings.
Por ejemplo para verificar si un usuario es administrador se debe hacer lo siguiente:

```php
if($user->hasRole(App\ROLE_ADMIN)){
    //TODO
}
```

### Administradores
Los administradores son los usuarios con acceso a la mayoría de acciones y gestión del sistema en general principálmente para realizar configuraciones. Estos usuarios pueden gestionar a los demás usuarios pero no eliminarse entre ellos.
El rol se encuentra en la constante `App\Role::ROLE_ADMIN`.

### Responsables
Los responsables son usuarios responsables de área, por ejemplo responsables de diseño y programación. Un responsable puede generar horarios de entrevistas y dar seguimiento a los candidatos a prácticas profesionales.
El rol se encuentra en la constante `App\Role::ROLE_RESPONSABLE`.

### Candidatos
Los candidatos son usuarios que agendan entrevistas con los responsables de área para obtener alguna de las vacantes disponibles.
El rol se encuentra en la constante `App\Role::ROLE_CANDIDATE`.

### Practicantes
Los practicantes son usuarios que fueron candidatos, fueron aceptados e inscritos satisfactoriamente en RAMA. Además un practicante tiene asociado un PIN que será usado para contabilizar sus horas en la app de RAMA.
El rol se encuentra en la constante `App\Role::ROLE_PRACTICING`.
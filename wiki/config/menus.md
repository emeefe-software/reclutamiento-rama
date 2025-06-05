# Menús frontend y admin
Tanto la plantilla frontend pública y la del admin contienen menús que a su vez pueden tener submenús, se crean 2 archivos de configuración en la carpeta `config` llamados `frontend.php` y `admin.php` ambos con una clave llamada `menus`.

Cada elemento del array `menus` tiene la siguiente estructura:

```php
[
    'title' => 'Titulo a mostrar en el menu',
    'icon' => 'Clase(s) del menú, solo si es menú de admin y principal, no subItem',
    'url' => 'URL a la que llevará al dar clic, solo si no tiene submenú',
    'route_name' => 'Nombre de la ruta en caso de no proporcionar url'
    'submenu' => [ //Array de subitems en caso de tener submenú
        [
            'title' => 'Título del subitem',
            'url' => 'URL a la que llevará al dar clic al sub item',
            'route_name' => 'Nombre de la ruta en caso de no proporcionar url'
        ],
        ...
    ]
],
```

De esta manera no tenemos que estar editando el código del header(para el frontend) ni el aside(para el admin).
gPOS - Gestión Puntos de Venta
==============================

gPOS es un fork de [9gestion Moda](http://sourceforge.net/projects/es9gestion/), basado en tecnologia XUL, javascript, PHP5.4 y MySQL.

gPOS se distribuye con licencia LGPL v2.1

Instalación
----------

1. Modifique los permisos de las siguientes carpetas

    chown apache:apache  gpos/ -Rf

    chmod 740 gpos/ -Rf

2. En su navegador firefox ingrese a `http://tudominio/gpos/`.

3. Si el instalador automático de xulremote falle, configure manualmente.

4. Borre la carpeta install por seguridad.

5. Modifique las contraseñas por defecto del local `Local:almacen, Contraseña:almacen`, del usuario `Usuario : admin, Contraseña : admin`, de mantenimiento `Usuario:soporte, Contraseña: soporte`. Otros locales registrados `local:localuno, contraseña:localuno, local:localdos, contraseña:localdos`.

Documentación
-------------

* [Manual de usuario](http://genack.net/genack/services/gpos/user_manual/inicio)


Contribución
------------

* [ekiss.biz](http://ekiss.biz)  diseño de iconos, documentación.
* [genack.net](http://genack.net)  diseño y desarrollo.

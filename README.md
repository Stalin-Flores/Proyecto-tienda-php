# 🏪 Software Tienda - Sistema de Gestión de Clientes

Un sistema web desarrollado en **PHP** que permite gestionar de manera eficiente el registro, actualización y eliminación de clientes para una tienda.

## 📋 Descripción

Este proyecto es una aplicación CRUD (Create, Read, Update, Delete) que facilita la administración de clientes. Permite registrar nuevos clientes, visualizar un listado completo, actualizar su información y eliminar registros.

## 🎯 Características Principales

✅ **Registro de Clientes**: Agregar nuevos clientes con nombre, número de identificación y tipo de identificación  
✅ **Visualización**: Tabla de clientes con búsqueda y filtrado de datos (DataTables)  
✅ **Actualización**: Modificar información de clientes existentes  
✅ **Eliminación**: Borrar registros de clientes  
✅ **Validación**: Validación de datos tanto en cliente como en servidor  
✅ **Notificaciones**: Mensajes visuales con SweetAlert2  
✅ **Sesiones**: Control de sesiones para seguimiento de acciones  

## 🛠️ Tecnologías Utilizadas

- **PHP 8.3**: Lenguaje del servidor (última versión)
- **MySQL/MariaDB**: Base de datos
- **PDO**: Para conexiones seguras a la base de datos
- **Bootstrap 5.3.3**: Framework CSS para interfaz responsiva
- **DataTables 1.13.6**: Tabla interactiva con búsqueda y paginación
- **SweetAlert2**: Alertas personalizadas
- **JavaScript**: Interactividad del lado del cliente

## 📁 Estructura del Proyecto

```
tienda/
├── README.md                      # Este archivo
├── RegistroCliente.php            # Página principal - gestión de clientes
├── db/
│   └── db.php                     # Configuración de conexión a BD
├── actualizar/
│   └── actualizar.php             # Formulario para actualizar cliente
└── eliminar/
    └── eliminar.php               # Script para eliminar cliente
```

## 🗄️ Base de Datos

El proyecto utiliza las siguientes tablas:

### Tabla `cliente`
```sql
CREATE TABLE cliente (
    cod_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    numero_identificacion VARCHAR(50) NOT NULL,
    cod_tipo_ide INT NOT NULL,
    FOREIGN KEY (cod_tipo_ide) REFERENCES tipo_identificacion(cod_tipo_ide)
);
```

### Tabla `tipo_identificacion`
```sql
CREATE TABLE tipo_identificacion (
    cod_tipo_ide INT PRIMARY KEY AUTO_INCREMENT,
    tipo_identificacion VARCHAR(50) NOT NULL
);
```

## 📖 Cómo Usar

### 1. Configuración Inicial

**Edita el archivo `db/db.php`** con tus credenciales:

```php
$host = "localhost";
$usuario = "root";
$clave = "mysql";
$base_de_datos = "tienda";
```

### 2. Crear la Base de Datos

Ejecuta los scripts SQL en tu gestor de base de datos (phpMyAdmin, MySQL Workbench, etc.)

### 3. Acceder a la Aplicación

- Coloca la carpeta en la raíz de XAMPP: `htdocs/PHP/tienda`
- Abre tu navegador e ingresa: `http://localhost/PHP/tienda/RegistroCliente.php`

### 4. Operaciones Disponibles

| Operación | Descripción |
|-----------|-------------|
| **Registrar Cliente** | Completa el formulario y haz clic en "Registrar" |
| **Ver Clientes** | La tabla muestra todos los clientes registrados |
| **Actualizar** | Haz clic en "Editar" para modificar un cliente |
| **Eliminar** | Haz clic en "Eliminar" para borrar un cliente |

## 📄 Archivos Principales

### `RegistroCliente.php`
- Página principal de la aplicación
- Formulario para registrar nuevos clientes
- Tabla con listado de todos los clientes
- Manejo de sesiones para mensajes de confirmación
- Integración con Bootstrap y DataTables

### `db/db.php`
- Configuración de conexión a MySQL
- Uso de PDO para mayor seguridad
- Manejo de excepciones

### `actualizar/actualizar.php`
- Formulario para editar información del cliente
- Validación de datos
- Actualización en la base de datos

### `eliminar/eliminar.php`
- Script para eliminar un cliente
- Recibe el código del cliente por POST
- Redirige al listado principal

## 🔒 Seguridad

- ✅ Uso de **prepared statements** para prevenir inyección SQL
- ✅ **Validación de datos** en el servidor
- ✅ **Sesiones** para control de acceso
- ✅ **Trim()** para limpiar espacios en blanco

## ⚠️ Requisitos

- Servidor web con **PHP 8.3** (última versión)
- MySQL 5.7+ o MariaDB
- Extensión PDO habilitada
- XAMPP (o servidor equivalente)

## 🚀 Próximas Mejoras

- [ ] Autenticación de usuarios
- [ ] Roles y permisos
- [ ] Exportación de datos (PDF/Excel)
- [ ] Búsqueda avanzada
- [ ] Historial de cambios
- [ ] API REST
- [ ] Panel de estadísticas

## 👨‍💻 Autor

Proyecto desarrollado para la gestión de clientes de una tienda.

**Fecha de creación:** 10 de noviembre de 2025

## 📝 Licencia

Este proyecto es de código abierto y puede ser utilizado libremente.

---

**¿Necesitas ayuda?** Revisa los archivos PHP o consulta la documentación de las tecnologías utilizadas.

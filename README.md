# PushMundo 🚀

Sistema CRM desarrollado con Laravel + AdminLTE para gestión de clientes, productos, proveedores, empleados y facturas.

---

## Funcionalidades implementadas ✅

- Autenticación y panel administrativo con AdminLTE.
- CRUD completo de:
	- Clientes
	- Productos
	- Proveedores
	- Empleados
	- Facturas
- Soft delete, restauración y eliminación permanente.
- DataTables en listados (búsqueda rápida) + paginación Laravel.
- Gestión de roles:
	- `admin`
	- `usuario`
- Permisos por rol:
	- `admin`: puede eliminar y gestionar roles.
	- `usuario`: crear/editar (sin acciones de eliminar).
- Subida de archivos:
	- Foto de cliente.
	- Imagen y PDF en productos.
	- PDF en facturas.

---

## Requisitos del entorno 🧰

- PHP 8.1+ (8.2 recomendado)
- Composer
- Node.js + npm
- MySQL / MariaDB
- XAMPP (Windows)

---

## Instalación y arranque rápido ⚙️

1) Instalar dependencias:

```bash
composer install
npm install
```

2) Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

3) Configurar base de datos en `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4) Ejecutar migraciones y seeders:

```bash
php artisan migrate
php artisan db:seed
```

5) Crear enlace de storage público:

```bash
php artisan storage:link
```

6) Levantar servidor:

```bash
php artisan serve
```

Abrir en navegador: `http://127.0.0.1:8000`

---

## Cuentas de prueba (roles) 🧪

> Solo para entorno local/desarrollo.

### Administrador
- Email: `admin.demo@pushmundo.com`
- Password: `AdminDemo123!`
- Rol: `admin`

### Usuario
- Email: `usuario.demo@pushmundo.com`
- Password: `UsuarioDemo123!`
- Rol: `usuario`

### Administrador adicional (si ya estaba creado)
- Email: `admin@admin.com`
- Password: `Admin12345!`
- Rol: `admin`

---

## Gestión de roles 👥

- Ruta: `/usuarios`
- Visible para administradores.
- Permite cambiar rol con botones:
	- “Hacer Admin”
	- “Hacer Usuario”

---

## Subida de archivos 📎

- Cliente: foto en alta/edición.
- Producto: imagen + ficha técnica PDF.
- Factura: PDF adjunto en alta/edición.
- Las URLs de media se generan en formato relativo (`/storage/...`) para evitar errores por host/puerto.

---

## Verificación rápida de calidad ✅

```bash
php artisan optimize:clear
php artisan test
```

---

## Notas de seguridad ⚠️

- Cambia todas las contraseñas de prueba antes de pasar a producción.
- No publiques credenciales reales en repositorios públicos.
- Mantén `APP_DEBUG=false` en producción.

---



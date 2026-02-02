# PushMundo 🚀

**Proyecto Laravel** con autenticación y panel administrativo basado en AdminLTE. Incluye entidades comunes (Clientes, Productos, Proveedores, Empleados, Facturas) y una estructura lista para desarrollo local.

---

## Descripción del proyecto 🔧

Aplicación web desarrollada con Laravel. Provee un sistema básico de autenticación, panel administrativo (AdminLTE) y scaffolding para modelos, migraciones, controladores, factories y seeders.

---

## Requisitos para ejecutarlo ✅

- PHP 8.0+ (recomendado 8.1/8.2)
- Composer
- Node.js (16+) y npm
- Servidor de base de datos (MySQL / MariaDB)
- XAMPP o similar en Windows
- Extensiones de PHP: openssl, pdo, pdo_mysql, mbstring, tokenizer, xml, ctype, json, fileinfo
- Git (opcional)

---

## Pasos básicos de instalación (rápido) 📋

1. Crear el proyecto Laravel y moverte al directorio:

```bash
composer create-project laravel/laravel nombre_proyecto
cd nombre_proyecto
```

2. Instalar Laravel UI (opcional para generar vistas de auth):

```bash
composer require laravel/ui
```

3. Generar vistas de autenticación con Bootstrap:

```bash
php artisan ui bootstrap --auth
```

- Cuando pregunte, confirme la sobrescritura de archivos si es necesario (responder `yes`).

4. Instalar dependencias frontend:

```bash
npm install
```

5. Compilar assets para desarrollo:

```bash
npm run dev
```

6. Configurar la base de datos en el archivo `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.) y generar clave de aplicación:

```bash
cp .env.example .env
# editar .env según correspondan los datos de BD
php artisan key:generate
```

7. Ejecutar migraciones:

```bash
php artisan migrate
```

8. Instalar AdminLTE (panel administrativo):

```bash
composer require jeroennoten/laravel-adminlte
```

9. Instalar AdminLTE con tipo completo:

```bash
php artisan adminlte:install --type=full
```

10. Copiar/ajustar el layout principal (`app.blade.php`) desde el repo de AdminLTE si quieres usar el layout recomendado:

- Repositorio: https://github.com/jeroennoten/Laravel-AdminLTE
- Sustituir o adaptar `resources/views/layouts/app.blade.php` según instrucciones.

11. Crear modelos con migración, controlador, factory y seeder de forma automática:

```bash
php artisan make:model NombreModelo -mcfs
```

- Esto crea: Modelo (-m), Migración (-m), Controlador (-c), Factory (-f) y Seeder (-s).


### Comandos útiles adicionales 🔧

- Levantar servidor de desarrollo:

```bash
php artisan serve
# -> http://127.0.0.1:8000
```

- Ejecutar seeders (si los tienes):

```bash
php artisan db:seed
```

---

## Usuario y contraseña de prueba (para desarrollo) 🧪

Crea un usuario de prueba ejecutando un seeder o desde Tinker. Ejemplo (solo para desarrollo):

- **Email:** `admin@example.com`
- **Password:** `password` (cámbialo en producción)

Ejemplo rápido con Tinker:

```bash
php artisan tinker
>>> \App\Models\User::factory()->create(["email" => "admin@example.com", "password" => bcrypt("password")]);
```

---

## Notas finales ⚠️

- Mantén las credenciales seguras en producción y no uses contraseñas débiles.
- Revisa la documentación oficial de Laravel y de AdminLTE para opciones avanzadas y customización.
- Las credenciales para entrar en la base de datos si las pide son Usuario: root y Contraseña: Carlos_0098

---



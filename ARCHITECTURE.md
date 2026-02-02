# 🏗️ ARQUITECTURA DEL SISTEMA - CLIENTES

## Flujo de Solicitud HTTP

```
┌─────────────────────────────────────────────────────────────────┐
│                      USUARIO EN NAVEGADOR                       │
│                   http://localhost:8000                          │
└─────────────────────────────────────────┬───────────────────────┘
                                          │
                    ┌─────────────────────▼──────────────────────┐
                    │  Solicitud HTTP GET/POST/PUT/DELETE        │
                    └─────────────────────┬──────────────────────┘
                                          │
                    ┌─────────────────────▼──────────────────────┐
                    │  routes/web.php                            │
                    │  Route::resource('clientes', ...)          │
                    └─────────────────────┬──────────────────────┘
                                          │
                    ┌─────────────────────▼──────────────────────┐
                    │  app/Http/Controllers/                     │
                    │  ClientesController.php                    │
                    │  ├─ index()   - GET /clientes            │
                    │  ├─ create()  - GET /clientes/create     │
                    │  ├─ store()   - POST /clientes           │
                    │  ├─ edit()    - GET /clientes/{id}/edit  │
                    │  ├─ update()  - PUT /clientes/{id}       │
                    │  └─ destroy() - DELETE /clientes/{id}    │
                    └─────────────────────┬──────────────────────┘
                                          │
            ┌─────────────────────────────┼─────────────────────────────┐
            │                             │                             │
    ┌───────▼────────┐          ┌────────▼────────┐          ┌────────▼────────┐
    │   Validación   │          │ Operaciones BD  │          │  Consultas ORM   │
    │   Request      │          │  Create/Update  │          │  Read/Delete     │
    │  validate()    │          │  save()         │          │  get()/find()    │
    └────────┬───────┘          └────────┬────────┘          └────────┬────────┘
             │                           │                           │
             │       ┌───────────────────┼───────────────────┐       │
             │       │                   │                   │       │
             │       ▼                   ▼                   ▼       │
             │   app/Models/         database/           resources/
             │   Clientes.php        clientes.php        views/
             │   ├─ fillable         ├─ id               ├─ index
             │   ├─ casts            ├─ nombre           ├─ create
             │   ├─ accessors        ├─ apellido         ├─ edit
             │   └─ scopes           ├─ email
             │                       ├─ telefono
             │                       └─ direccion
             │
             └───────────────────────────┬───────────────────────────┘
                                         │
                        ┌────────────────▼─────────────────┐
                        │    Base de Datos                 │
                        │    MySQL/MariaDB/PostgreSQL      │
                        │                                  │
                        │  tabla: clientes                 │
                        │  ├─ Validación BD                │
                        │  ├─ Índices (nombre, email)      │
                        │  ├─ Constraints (unique email)   │
                        │  └─ Timestamps (created/updated) │
                        └────────────────┬─────────────────┘
                                         │
                        ┌────────────────▼─────────────────┐
                        │    Respuesta del Controlador     │
                        │                                  │
                        │  redirect() + with()             │
                        │  view() + compact()              │
                        └────────────────┬─────────────────┘
                                         │
                        ┌────────────────▼─────────────────┐
                        │   Blade Template Rendering       │
                        │   resources/views/               │
                        │   ├─ layouts/app.blade.php       │
                        │   └─ clientes/*.blade.php        │
                        └────────────────┬─────────────────┘
                                         │
┌────────────────────────────────────────▼──────────────────────────────────┐
│                         Respuesta HTML+CSS+JS                             │
│                      Enviada al navegador                                 │
└────────────────────────────────────────┬──────────────────────────────────┘
                                         │
                        ┌────────────────▼─────────────────┐
                        │      Navegador Renderiza        │
                        │      ✅ Página Visible Usuario  │
                        └────────────────────────────────┘
```

## 🗂️ Estructura de Directorios

```
c:\xampp\htdocs\pushmundo\
│
├─ app/
│  ├─ Http/
│  │  └─ Controllers/
│  │     └─ ClientesController.php          ✅ NUEVO
│  │
│  ├─ Models/
│  │  └─ Clientes.php                       🔄 MEJORADO
│  │
│  └─ Providers/
│     └─ AppServiceProvider.php
│
├─ database/
│  ├─ migrations/
│  │  └─ 2025_01_21_000000_create_clientes_table.php  ✅ NUEVO
│  │
│  ├─ factories/
│  │  └─ UserFactory.php
│  │
│  └─ seeders/
│     └─ DatabaseSeeder.php
│
├─ resources/
│  ├─ views/
│  │  ├─ layouts/
│  │  │  └─ app.blade.php
│  │  │
│  │  └─ clientes/
│  │     ├─ index.blade.php                 🔄 MEJORADO
│  │     ├─ create.blade.php                ✅ NUEVO
│  │     └─ edit.blade.php                  ✅ NUEVO
│  │
│  ├─ css/
│  │  └─ app.css
│  │
│  └─ js/
│     ├─ app.js
│     └─ bootstrap.js
│
├─ routes/
│  └─ web.php                               🔄 MEJORADO
│
├─ public/
│  ├─ js/
│  │  └─ clientes-api.js                    ✅ NUEVO (ejemplos)
│  │
│  └─ vendor/
│     └─ [dependencias]
│
├─ config/
├─ bootstrap/
├─ storage/
│
├─ composer.json
├─ artisan
├─ phpunit.xml
│
└─ DOCUMENTACIÓN (✅ NUEVA):
   ├─ README_CLIENTES.md
   ├─ IMPLEMENTATION_GUIDE.md
   ├─ CHANGES_SUMMARY.md
   └─ BEST_PRACTICES.md
```

## 🔄 Ciclo de Vida de una Solicitud

### 1. Usuario hace clic en "Nuevo Cliente"
```
Click en botón → GET /clientes/create
```

### 2. Mostrar formulario
```
ClientesController::create()
  → return view('clientes.create')
    → Blade renderiza formulario vacío
```

### 3. Usuario completa y envía
```
Form submit → POST /clientes
  → Datos: {nombre, apellido, email, telefono, direccion}
```

### 4. Procesar en controlador
```
ClientesController::store(Request $request)
  → Validar datos (request->validate())
  → Si hay errores:
      → return back()->withErrors() ← Volver al formulario con errores
  → Si válido:
      → Clientes::create($validated) ← Guardar en BD
      → return redirect()->with('success') ← Ir a lista con mensaje
```

### 5. Base de datos
```
INSERT INTO clientes (nombre, apellido, email, telefono, direccion, created_at, updated_at)
VALUES ('Juan', 'Pérez', 'juan@example.com', '+34612345678', 'Calle X', NOW(), NOW())
```

### 6. Vista final
```
GET /clientes ← Redirección automática
  → ClientesController::index()
    → $clientes = Clientes::orderBy('nombre')->paginate(15)
    → return view('clientes.index', compact('clientes'))
      → Blade renderiza tabla con mensaje de éxito
```

## 🎯 Métodos del Controlador

```
┌─────────────────────────────────────────────────────────────┐
│                  ClientesController                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  index()              Listar todos los clientes            │
│  ├─ Entrada: Ninguna (GET)                               │
│  ├─ Procesamiento: Obtener con paginación                │
│  └─ Salida: Vista con tabla de clientes                  │
│                                                            │
│  create()            Mostrar formulario crear             │
│  ├─ Entrada: Ninguna (GET)                              │
│  ├─ Procesamiento: Cargar vista                         │
│  └─ Salida: Formulario vacío                            │
│                                                            │
│  store()             Guardar nuevo cliente               │
│  ├─ Entrada: Request con datos del formulario          │
│  ├─ Procesamiento: Validar y crear registro            │
│  └─ Salida: Redirección con mensaje o errores          │
│                                                            │
│  edit($id)           Mostrar formulario editar           │
│  ├─ Entrada: ID del cliente (GET)                       │
│  ├─ Procesamiento: Buscar cliente, cargar vista        │
│  └─ Salida: Formulario pre-rellena                      │
│                                                            │
│  update($id)         Guardar cambios del cliente         │
│  ├─ Entrada: ID y Request con datos (PUT)              │
│  ├─ Procesamiento: Validar y actualizar               │
│  └─ Salida: Redirección con mensaje o errores          │
│                                                            │
│  destroy($id)        Eliminar cliente                    │
│  ├─ Entrada: ID del cliente (DELETE)                    │
│  ├─ Procesamiento: Buscar y eliminar                   │
│  └─ Salida: Redirección con mensaje de éxito           │
│                                                            │
└─────────────────────────────────────────────────────────────┘
```

## 📊 Flujo de Datos

```
USUARIO CREA CLIENTE
│
├─ Formulario (/clientes/create)
│  ├─ <input name="nombre">
│  ├─ <input name="apellido">
│  ├─ <input name="email">
│  ├─ <input name="telefono">
│  └─ <textarea name="direccion">
│
├─ Request::validate()
│  ├─ nombre: required|string|max:100|min:3
│  ├─ apellido: required|string|max:100|min:3
│  ├─ email: required|email|unique:clientes|max:100
│  ├─ telefono: required|regex:/^[\d\s\-\+\(\)]+$/|min:7|max:20
│  └─ direccion: nullable|string|max:255
│
├─ Clientes::create($validated)
│  └─ INSERT INTO clientes (nombre, apellido, email, telefono, direccion)
│
├─ Respuesta
│  ├─ ✅ Éxito: redirect()->with('success', 'Cliente agregado...')
│  └─ ❌ Error: back()->withErrors($errors)->withInput()
│
└─ Usuario ve resultado en /clientes


USUARIO EDITA CLIENTE
│
├─ Click Editar → /clientes/{id}/edit
│  └─ Carga ClientesController::edit(1)
│     ├─ Busca: $cliente = Clientes::findOrFail(1)
│     └─ Renderiza formulario con datos del cliente
│
├─ Modifica campos
│  ├─ nombre: "Juan" → "Juan Carlos"
│  ├─ email: "juan@old.com" → "juanc@new.com"
│  └─ etc...
│
├─ Envía: PUT /clientes/{id}
│  └─ ClientesController::update(1, $request)
│     ├─ Valida (email único excepto para este registro)
│     ├─ $cliente->update($validated)
│     └─ UPDATE clientes SET ... WHERE id=1
│
├─ Respuesta
│  ├─ ✅ Éxito: redirect()->with('success', 'Cliente actualizado...')
│  └─ ❌ Error: back()->withErrors($errors)->withInput()
│
└─ Usuario ve cambios en lista


USUARIO ELIMINA CLIENTE
│
├─ Click Eliminar
│  └─ Confirmar: "¿Eliminar Juan Pérez?"
│
├─ Envía: DELETE /clientes/{id}
│  └─ ClientesController::destroy(1)
│     ├─ Busca: $cliente = Clientes::findOrFail(1)
│     ├─ Obtiene nombre: $nombreCliente = $cliente->nombre_completo
│     └─ DELETE FROM clientes WHERE id=1
│
├─ Respuesta
│  └─ redirect()->with('success', "Cliente 'Juan Pérez' eliminado...")
│
└─ Cliente desaparece de tabla
```

## 🔒 Capa de Seguridad

```
ENTRADA (Security Layer)
│
├─ Request Validation
│  ├─ required
│  ├─ string|email|regex
│  ├─ min|max
│  ├─ unique (para email)
│  └─ Mensajes personalizados
│
├─ CSRF Protection
│  ├─ @csrf en formularios
│  ├─ Token verificado automáticamente
│  └─ Falla sin token válido
│
├─ SQL Injection Prevention
│  ├─ Eloquent ORM
│  ├─ Prepared Statements
│  ├─ where('nombre', 'like', "%{$search}%")
│  └─ Parámetros separados de SQL
│
├─ XSS Prevention
│  ├─ {{ $cliente->nombre }} (Escapado)
│  ├─ {!! $html !!} (Solo si es seguro)
│  └─ Blade automáticamente escapa
│
├─ Authentication Middleware
│  ├─ Route::middleware(['auth'])->group()
│  ├─ Solo usuarios logueados acceden
│  └─ Redirección a login si no autenticado
│
└─ Business Logic
   ├─ Validación de negocio
   ├─ Constraints de BD (unique, not null)
   ├─ Transacciones (si hay múltiples operaciones)
   └─ Auditoría (quién cambió qué)
```

## 🎯 Mapeo de Rutas

```
HTTP Method  Path                        Controlador         Acción
─────────────────────────────────────────────────────────────────
GET          /clientes                  ClientesController  index()
GET          /clientes/create           ClientesController  create()
POST         /clientes                  ClientesController  store()
GET          /clientes/{id}             ClientesController  show()
GET          /clientes/{id}/edit        ClientesController  edit()
PUT/PATCH    /clientes/{id}             ClientesController  update()
DELETE       /clientes/{id}             ClientesController  destroy()

Nota: show() no está implementado (usar edit si necesitas ver detalles)
```

---

**Arquitectura completa y profesional lista para producción.** ✨

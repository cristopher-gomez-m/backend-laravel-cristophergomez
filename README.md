# 📌 Sistema de Gestión de Citas (Backend)

Backend para la gestión de citas de una peluquería, desarrollado con **Laravel 10** y **PHP 8.2.12**, usando **MySQL** como base de datos.

---

## 🛠 Tecnologías utilizadas

- **Backend:** PHP 8.2.12 + Laravel 10  
- **Base de datos:** MySQL  
- **Gestión de dependencias:** Composer  
- **Control de versiones:** Git  

---

## 🔑 Autenticación

- Modelo `User` para login con `username` y `password`.  
- Auditoría en todos los modelos:  
  - `fecha_ingreso`, `usuario_id`  
  - `fecha_modifica`, `usuario_modifica_id`  
  - `fecha_elimina`, `usuario_elimina_id`  
- **Borrado lógico** mediante el campo `status`:  
  - `A` → Activo  
  - `E` → Eliminado  
  - `I` → Inactivo  

---

## 📋 Modelos y relaciones

### Clientes (`Cliente`)
- Campos: `id`, `nombres`, auditoría, `status`  
- CRUD completo

### Atenciones (`Atencion`)
- Campos: `id`, `nombre`, `precio`, auditoría, `status`  
- CRUD completo

### Citas (`Cita`)
- Campos: `id`, `fecha`, `hora`, `cliente_id`, auditoría, `status`  
- Relación: una cita puede tener muchos **CitaDetalle**

### CitaDetalle (`CitaDetalle`)
- Campos: `id`, `cita_id`, `atencion_id`, auditoría, `status`  
- Relación con `Cita` y `Atencion`

---

## ⚙️ Funcionalidades

1. **Usuarios:** Login y auditoría.  
2. **Clientes:** CRUD con validaciones y borrado lógico.  
3. **Atenciones:** CRUD con precios y auditoría.  
4. **Citas:** CRUD con relación a clientes y detalles de atenciones:
   - Agregar múltiples atenciones por cita (`detalleNuevo` y `detalleEliminar`)  
   - Auditoría de cambios y borrado lógico  

---

## 🗂 Estructura de carpetas

```text
backend-laravel/
├─ app/
│  ├─ Models/
│  │  ├─ User.php
│  │  ├─ Cliente.php
│  │  ├─ Atencion.php
│  │  ├─ Cita.php
│  │  └─ CitaDetalle.php
│  └─ Http/Controllers/
├─ database/
│  ├─ migrations/
│  └─ seeders/
└─ routes/
   └─ api.php
```


---

## ⚡ Instalación


Crea un archivo `.env` en la raíz del proyecto y define las variables necesarias. Ejemplo:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:XXXXXXXXXXXXXX
APP_DEBUG=true
APP_URL=http://localhost

APP_MAINTENANCE_DRIVER=file
CACHE_STORE=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peluqueria
DB_USERNAME=root
DB_PASSWORD=123

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

WT_SECRET=aR0HqKy0CpXsOhSqFw96w4vsssKZKtCGouyTn4YFqOBAEuuOLqK0dFvdIKXUiQFJ

```

```bash
# Clonar el repositorio
git clone https://github.com/cristopher-gomez-m/backend-laravel-cristophergomez
cd backend-laravel-cristophergomez

# Instalar dependencias
composer install

# Configurar .env
cp .env.example .env

# Ajusta DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_KEY

# Generar llave de la app
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Iniciar servidor
php artisan serve


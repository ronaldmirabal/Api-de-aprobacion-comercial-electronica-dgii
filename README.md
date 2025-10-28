<p align="center">
  <img src="https://raw.githubusercontent.com/ronaldmirabal/Api-de-aprobacion-comercial-electronica-dgii/main/public/assets/images/dgiilogo.png" alt="Logo" width="150">
</p>

# Api de Aprobacion Comercial Electronica de la Dgii
![Laravel](https://img.shields.io/badge/Laravel-12-red.svg?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.2+-8A2BE2?style=for-the-badge)
![DGII](https://img.shields.io/badge/DGII-COMPATIBLE-brightgreen?style=for-the-badge)

Sistema de aprobación comercial DGII desarrollado con Laravel 12. Esta API fue desarrollada con el propósito de facilitar el proceso de aprobación comercial ante la DGII, especialmente para aquellos desarrolladores que ya cuentan con sistemas en entornos de escritorio y necesitan disponer de una URL pública para recibir los comprobantes electrónicos emitidos por otras empresas. Con esta solución, se busca agilizar la integración y puesta en marcha del proceso de recepción de comprobantes, ofreciendo una herramienta lista para conectarse con los servicios de la DGII sin necesidad de modificar los sistemas locales existentes.

# ⚙️ Instalación del Proyecto Laravel
## :clipboard: Requisitos
- PHP ^8.2
- Laravel ^12.0
- Mysql

## 🚀 Instalación Paso a Paso
### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/ronaldmirabal/Api-de-aprobacion-comercial-electronica-dgii.git
cd Api-de-aprobacion-comercial-electronica-dgii
```
### 2️⃣ Instalar dependencias de PHP
```bash
composer install
```
### 3️⃣ Configurar el archivo .env
```bash
cp .env.example .env
```
### 4️⃣ Edita el archivo .env y actualiza los valores según tu entorno:
```env
APP_NAME="Mi Proyecto Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña

FIRMAP12_PASSWORD=123456789 //Contraseña del .p12
URL_CERTIFICADOP12=app/public/ssl/mifirma.p12 //Ubicación del archivo de la firma .p12
```
### 5️⃣ Generar la clave de aplicación
```bash
php artisan key:generate
```
### 6️⃣ Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

# 🚀 Cómo Aportar

1. **Haz un Fork del repositorio**
   - En la parte superior derecha de esta página, haz clic en el botón **Fork**.
   - Esto creará una copia del proyecto en tu cuenta de GitHub.

2. **Clona tu fork localmente**
```bash
   git clone https://github.com/tu-usuario/nombre-del-repositorio.git
   cd nombre-del-repositorio
```

3. Crea una nueva rama para tu contribución
```bash
git checkout -b nombre-de-tu-rama
```

4. Usa un nombre descriptivo, por ejemplo:
```bash
  fix/error-en-login
  feature/nueva-funcionalidad
  doc/mejorar-readme
```

5. Envía tu Contribución
```bash
git push origin nombre-de-tu-rama
```
6. En GitHub, abre una Pull Request (PR)
- Explica qué problema resuelve o qué mejora implementa.
- Añade capturas de pantalla si aplica.
- Espera la revisión.

## Credits

- [Ronald Mirabal](https://github.com/ronaldmirabal)
- [All Contributors](../../contributors)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


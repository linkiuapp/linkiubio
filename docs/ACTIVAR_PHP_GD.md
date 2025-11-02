# Cómo Activar la Extensión PHP GD

La extensión PHP GD es necesaria para generar códigos QR en el sistema.

## Windows (XAMPP)

1. **Abrir php.ini:**
   - Ve a: `C:\xampp\php\php.ini`
   - Ábrelo con un editor de texto (Notepad++, VS Code, etc.)

2. **Buscar y descomentar las extensiones necesarias:**
   - Busca `extension=gd` (Ctrl+F)
   - Si tiene `;` al inicio, quítalo:
     ```ini
     ;extension=gd    ← Quitar el punto y coma
     extension=gd     ← Debe quedar así
     ```
   
   - También busca `extension=zip` (necesaria para otras dependencias):
     ```ini
     ;extension=zip   ← Quitar el punto y coma
     extension=zip    ← Debe quedar así
     ```

3. **Reiniciar Apache:**
   - Abre el Panel de Control de XAMPP
   - Detén Apache
   - Inicia Apache nuevamente

4. **Verificar:**
   ```bash
   php -m | findstr /i "gd"
   ```
   Debería mostrar `gd`

   O ejecutar:
   ```bash
   php -r "echo extension_loaded('gd') ? 'GD está activado' : 'GD NO está activado';"
   ```

## Windows (Laragon)

1. **Abrir php.ini:**
   - Abre Laragon
   - Haz clic en "Menu" → "PHP" → "php.ini" (o la versión que uses)

2. **Buscar y descomentar:**
   ```ini
   ;extension=gd
   ```
   Cambiar a:
   ```ini
   extension=gd
   ```
   (Quitar el punto y coma `;` al inicio)

3. **Reiniciar Laragon:**
   - Cierra y vuelve a abrir Laragon
   - O detén e inicia el servicio Apache

4. **Verificar:**
   ```bash
   php -m | grep -i gd
   ```
   Debería mostrar `gd`

   O ejecutar:
   ```bash
   php -r "echo extension_loaded('gd') ? 'GD está activado' : 'GD NO está activado';"
   ```

## Linux (Ubuntu/Debian)

```bash
sudo apt-get update
sudo apt-get install php-gd
sudo systemctl restart apache2  # o php-fpm
```

## Linux (CentOS/RHEL)

```bash
sudo yum install php-gd
sudo systemctl restart httpd  # o php-fpm
```

## Verificar desde PHP

En tu código PHP:
```php
if (extension_loaded('gd')) {
    echo "GD está activado";
} else {
    echo "GD NO está activado";
}
```

## Después de activar GD

Instalar la librería de QR:
```bash
composer require simplesoftwareio/simple-qrcode
```

## Nota

En Laragon (Windows), generalmente GD ya viene habilitado por defecto. Si no, sigue los pasos anteriores.

